<?php

namespace App\Services\SupportTicketService;
use App\Models\SupportTicket;
use App\Http\Requests\User\SupportTicketRequest;
use App\Http\Requests\User\ReplaySupportTicketRequest;

interface AppSupportTicketService{

    /**
     * createNewTicket function to create new Support Ticket.
     *
     * @param SupportTicketRequest $request
     * @return array
     */
    public function createNewTicket(SupportTicketRequest $request): array;

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
    public static function findSupportTicketOrThrow(string $ticket,?int $user_id = null,bool $throw = false,string $redirect = null):  SupportTicket;

    /**
     * replayToTicket function to reply on Support Ticket.
     *
     * @param ReplaySupportTicketRequest $request
     * @return array
     */
    public function replayToTicket(ReplaySupportTicketRequest $request): array;

    /**
     * Close Ticket
     * @param string $ticket
     * @return array
     */
    public function closeTicket(string $ticket): array;

    /**
     * Get Ticket Details Page Data
     * @param string $ticket
     * @return array
     */
    public function getTicketDetailsPageData(string $ticket): array;

    /**
     * Find Replay Attachment
     * @param string $replay
     * @param string $index
     * @return array
     */
    public function findReplayAttachment(string $replay, string $index): array;

}