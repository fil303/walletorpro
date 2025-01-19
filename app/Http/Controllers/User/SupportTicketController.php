<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Models\SupportTicket;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Http\Requests\User\SupportTicketRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\User\ReplaySupportTicketRequest;
use App\Services\SupportTicketService\AppSupportTicketService;

class SupportTicketController extends Controller
{
    public function __construct(protected AppSupportTicketService $service){}

    /**
     * View Support Ticket Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function supportPage(Request $request): mixed
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
            $tickets = SupportTicket::forUser()->orderBy('id', 'DESC')->paginate($perPage)->onEachSide(1);
            $tickets->map(function($item){

                $html = view('user.support.components.ticket_row', ['ticket' => $item]);

                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });
            return $tickets;
        }
        return view("user.support.index");
    }

    /**
     * View Support Ticket Page
     * @param string $ticket
     * @return mixed
     */
    public function supportTicketPage(string $ticket): mixed
    {
        return Response::send(
            response : $this->service->getTicketDetailsPageData($ticket),
            route    : "supportPage", // redirect here if error
            view     : "user.support.details"
            // view     : view("user.support.details", ($response['data'] ?? []))
        );
    }

    /**
     * Open New Support Ticket Page
     * @return mixed
     */
    public function openNewSupportTicketPage(): mixed
    {
        return view("user.support.create");
    }

    /**
     * Open New Support Ticket Page
     * @return mixed
     */
    public function openNewSupportPage(): mixed
    {
        return view("user.support.create");
    }

    /**
     * Submit New Support Ticket Page
     * @param \App\Http\Requests\User\SupportTicketRequest $request
     * @return mixed
     */
    public function submitNewSupportTicketPage(SupportTicketRequest $request): mixed
    {
        return Response::send(
            response: $this->service->createNewTicket($request),
            route   : 'supportPage'
        );
    }

    /**
     * Replay Support Ticket
     * @param \App\Http\Requests\User\ReplaySupportTicketRequest $request
     * @return mixed
     */
    public function replaySupportTicket(ReplaySupportTicketRequest $request): mixed
    {
        return Response::send(
            response: $this->service->replayToTicket($request)
        );
    }

    /**
     * Download Support Ticket Attachment
     * @param string $replay
     * @param string $index
     * @return mixed
     */
    public function supportTicketAttachmentDownload(string $replay, string $index): mixed
    {
        $response = $this->service->findReplayAttachment($replay, $index);

        if(!($response['status'] ?? false)){
            return Response::send(
                response : $response,
                route    : "supportPage", // redirect here if error
            );
        }

        /** @var ResponseFactory $responseTo */
        $responseTo = response();

        return $responseTo->download($response['data']['file'] ?? "");
    }

    /**
     * Close Ticket
     * @param string $ticket
     * @return mixed
     */
    public function closeTicketPage(string $ticket): mixed
    {
        return Response::send(
            response : $this->service->closeTicket($ticket),
            route    : "supportPage",
        );
    }
}
