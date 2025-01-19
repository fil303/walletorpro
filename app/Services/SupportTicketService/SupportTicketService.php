<?php

namespace App\Services\SupportTicketService;

use App\Models\SupportTicket;
use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;
use App\Enums\SupportTicketStatus;
use App\Facades\ResponseFacade;
use App\Models\SupportTicketReply;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\FileService\FileService;
use App\Services\ResponseService\Response;
use App\Http\Requests\User\SupportTicketRequest;
use App\Http\Requests\Admin\SupportTicketReplyRequest;
use App\Http\Requests\User\ReplaySupportTicketRequest;
use App\Services\SupportTicketService\AppSupportTicketService;

class SupportTicketService implements AppSupportTicketService
{
    public static SupportTicket $ticket;

    /**
     * getSupportTicket function to get Support Ticket.
     *
     * @return ?SupportTicket
     */
    public static function getSupportTicket(): ?SupportTicket
    {
        return self::$ticket;
    }

    /**
     * findSupportTicketOrThrow function to find Support Ticket.
     * If ticket not found this function can throw response 
     * and redirect to another route
     * 
     * @param string $ticket
     * @param ?int   $user_id
     * @param bool   $throw
     * @param string $redirect
     * 
     * @return SupportTicket
     */
    public static function findSupportTicketOrThrow(
        string $ticket,
        ?int $user_id    = null,
        bool $throw      = false,
        string $redirect = null
    ):  SupportTicket
    {
        self::$ticket = SupportTicket::ticket($ticket)->first();
        if(!self::$ticket && $throw){
            Response::throw(
                failed(_t("Support ticket not found")),
                $redirect ?? null
            );
        }

        return self::$ticket;
    }

    /**
     * createNewTicket function to create new Support Ticket.
     *
     * @param SupportTicketRequest $request
     * @return array
     */
    public function createNewTicket(SupportTicketRequest $request): array
    {
        $ticketData = [
            "user_id"    => Auth::id(),
            "ticket"     => uniqueCode(prefix: '', integer: true),
            "subject"    => $request->subject,
            "priority"   => $request->priority,
        ];

        DB::beginTransaction();
        try {
            if($ticket = SupportTicket::create($ticketData)){
                $replayData = new ReplaySupportTicketRequest([
                    "ticket"     => $ticket->ticket,
                    "message"    => $request->message,
                    // "attachment" => $request?->attachment
                ],  files: $request->allFiles());

                $replay = $this->replayToTicket($replayData);

                if($replay['status'] ?? false){
                    DB::commit();
                    return success(_t("New ticket opened successfully"));
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            logStore("createNewTicket", $e->getMessage());
        }
        return failed(_t("New ticket failed to open"));
    }

    /**
     * replayToTicket function to reply on Support Ticket.
     *
     * @param ReplaySupportTicketRequest $request
     * @return array
     */
    public function replayToTicket(ReplaySupportTicketRequest $request): array
    {
        // find ticket or return response to frontend
        self::findSupportTicketOrThrow(
            ticket : $request->ticket,
            user_id: $request->user_id ?? Auth::id(),
            throw  : true
        );

        if(self::$ticket->status == SupportTicketStatus::CLOSED)
        ResponseFacade::result(failed(_t("This ticket is closed")))->throw();

        $replayData = [
            "ticket"  => $request->ticket,
            "sender"  => Auth::id(),
            "message" => $request->message,
        ];
        
        if($request->hasFile('attachment')){
            $filesName = [];
            $fileService = new FileService();

            /** @var array<UploadedFile> $attachments */
            $attachments = $request->file('attachment');
            foreach ($attachments as $file) {
                $filesName[] = $fileService->saveImage(
                    $file,
                    FileDestination::TICKET_ATTACHMENT_PATH
                ) ?? "";
            }
            if($filesName){
                $replayData["attachment"] = json_encode($filesName);
            }
        }

        try {
            DB::beginTransaction();

            if(Auth::user()->role->isAdmin()){
                if(
                    !(
                        isset($request->status) && 
                        in_array(
                            $request->status,
                            array_keys(SupportTicketStatus::setReplayStatus())
                        ) &&
                        self::$ticket->update(["status" => $request->status])
                    )
                ){
                    DB::rollBack();
                    return failed(_t("Replay ticket status update failed"));
                }
            } else {
                self::$ticket->update(["status" => SupportTicketStatus::OPEN->value ]);
            }

            if($replay = SupportTicketReply::create($replayData)){
                DB::commit();
                return success(_t("Replayed ticket successfully"));
            }
        } catch (\Exception $e) {
            logStore("replayToTicket", $e->getMessage());
        }
        DB::rollBack();
        return failed(_t("Replay failed to ticket"));
    }

    /**
     * Close Ticket
     * @param string $ticket
     * @return array
     */
    public function closeTicket(string $ticket): array
    {
        $ticket = self::findSupportTicketOrThrow(
            ticket : $ticket,
            throw  : true
        );

        $ticket->status = SupportTicketStatus::CLOSED->value;

        if($ticket->save())
            return success(_t("Ticket closed successfully"));
        return failed(_t("Ticket failed to closed"));
    }

    /**
     * Get Ticket Details Page Data
     * @param string $ticket
     * @return array
     */
    public function getTicketDetailsPageData(string $ticket): array
    {
        if(!$ticket = SupportTicket::forUser()->ticket($ticket)->first())
            return failed(_t("Ticket not found"));

        $replies = SupportTicketReply::findByTicket($ticket->ticket)->with('sender_user')->get();

        if(isset($replies[0])){
            $replies->map(function($reply){
                $reply->attachmentData = json_decode($reply->attachment);
            });
        }

        return success(_t("Ticket details found successfully"), [
            "ticket"  => $ticket,
            "replies" => $replies
        ]);
    }

    /**
     * Find Replay Attachment
     * @param string $replay
     * @param string $index
     * @return array
     */
    public function findReplayAttachment(string $replay,  string $index): array
    {
        if(!$replay = SupportTicketReply::find($replay))
            return failed(_t("Attachment not found"));

        if($attachments = json_decode($replay->attachment)){
            if(isset($attachments[$index]) && filled($attachments[$index])){
                if(
                    file_exists( $file =
                        public_path(
                            enum(FileDestination::TICKET_ATTACHMENT_PATH).$attachments[$index]
                        )
                    )
                )   return success(_t("Attachment found successfully"), ["file" => $file]);
            }
        }
        
        return failed(_t("Attachment not found"));
    }

}