<?php

namespace App\Http\Controllers\Admin;

use App\Models\SupportTicket;
use Yajra\DataTables\DataTables;
use App\Enums\SupportTicketStatus;
use App\Models\SupportTicketReply;
use App\Enums\SupportTicketPriority;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\ResponseService\Response;
use App\Http\Requests\User\ReplaySupportTicketRequest;
use App\Services\SupportTicketService\AppSupportTicketService;
use App\Services\TableActionGeneratorService\SupportTicketTableAction\SupportTicketTableAction;

class SupportTicketController extends Controller
{
    public function __construct(protected AppSupportTicketService $service){}

    /**
     * View Support Ticket Page
     * @return mixed
     */
    public function index(): mixed
    {
        if (IS_API_REQUEST) {
            $tickets = SupportTicket::latest()->with('replies')->get();
            return DataTables::of($tickets)

                ->addColumn("user", function ($ticket) {
                    return $ticket->user?->first_name . " " . $ticket->user?->last_name;
                })
                ->editColumn("created_at", function ($ticket) {
                    return date('Y-m-d', strtotime($ticket->created_at));
                })
                ->editColumn("priority", function ($ticket) {
                    $priority = _t($ticket->priority->value);
                    $priority = strtoupper($priority);

                    $color = match ($ticket->priority) {
                        SupportTicketPriority::HIGH   => "error",
                        SupportTicketPriority::LOW    => "ghost",
                        SupportTicketPriority::MEDIUM => "info",
                        default => "primary"
                    };

                    return "<div class=\"badge badge-$color  badge-outline\">$priority</div>";
                })
                ->editColumn("status", function ($ticket) {
                    $status = _t($ticket->status->value);
                    $status = strtoupper($status);

                    $color  = match ($ticket->status) {
                        SupportTicketStatus::PENDING  => "primary",
                        SupportTicketStatus::CLOSED   => "ghost",
                        SupportTicketStatus::OPEN     => "primary",
                        SupportTicketStatus::ANSWERED => "info",
                        default => "primary"
                    };
                    
                    return "<div class=\"badge badge-$color  badge-outline\">$status</div>";
                })

                ->addColumn("action", function ($ticket) {
                    return SupportTicketTableAction::getInstance($ticket)->button();
                })

                ->rawColumns(['priority', 'status', 'action'])
                ->make(true);
        }

        return view('admin.tickets.index');
    }

    /**
     * Get Pending Tickets List
     * @return mixed
     */
    public function pending(): mixed
    {
        if (IS_API_REQUEST) {
            $tickets = SupportTicket::open()->latest()->with('user');
            return DataTables::of($tickets)

                ->addColumn("user", function ($ticket) {
                    return $ticket->user?->first_name . " " . $ticket->user?->last_name;
                })
                ->editColumn("created_at", function ($ticket) {
                    return date('Y-m-d', strtotime($ticket->created_at));
                })
                ->editColumn("priority", function ($ticket) {
                    $priority = _t($ticket->priority->value);
                    $priority = strtoupper($priority);

                    $color = match ($ticket->priority) {
                        SupportTicketPriority::HIGH   => "error",
                        SupportTicketPriority::LOW    => "ghost",
                        SupportTicketPriority::MEDIUM => "info",
                        default => "primary"
                    };

                    return "<div class=\"badge badge-$color  badge-outline\">$priority</div>";
                })
                ->editColumn("status", function ($ticket) {
                    $status = _t($ticket->status->value);
                    $status = strtoupper($status);

                    $color  = match ($ticket->status) {
                        SupportTicketStatus::PENDING  => "primary",
                        SupportTicketStatus::CLOSED   => "ghost",
                        SupportTicketStatus::OPEN     => "primary",
                        SupportTicketStatus::ANSWERED => "info",
                        default => "primary"
                    };
                    
                    return "<div class=\"badge badge-$color  badge-outline\">$status</div>";
                })

                ->addColumn("action", function ($ticket) {
                    return SupportTicketTableAction::getInstance($ticket)->button();
                })

                ->rawColumns(['priority', 'status', 'action'])
                ->make(true);
        }


        return view('admin.tickets.pending');
    }

    /**
     * Get Closed Tickets List
     * @return mixed
     */
    public function answered(): mixed
    {
        if (IS_API_REQUEST) {
            $tickets = SupportTicket::answered()->latest()->with('replies')->get();
            return DataTables::of($tickets)

                ->addColumn("user", function ($ticket) {
                    return $ticket->user?->first_name . " " . $ticket->user?->last_name;
                })
                ->editColumn("created_at", function ($ticket) {
                    return date('Y-m-d', strtotime($ticket->created_at));
                })
                ->editColumn("priority", function ($ticket) {
                    $priority = _t($ticket->priority->value);
                    $priority = strtoupper($priority);

                    $color = match ($ticket->priority) {
                        SupportTicketPriority::HIGH   => "error",
                        SupportTicketPriority::LOW    => "ghost",
                        SupportTicketPriority::MEDIUM => "info",
                        default => "primary"
                    };

                    return "<div class=\"badge badge-$color  badge-outline\">$priority</div>";
                })
                ->editColumn("status", function ($ticket) {
                    $status = _t($ticket->status->value);
                    $status = strtoupper($status);

                    $color  = match ($ticket->status) {
                        SupportTicketStatus::PENDING  => "primary",
                        SupportTicketStatus::CLOSED   => "ghost",
                        SupportTicketStatus::OPEN     => "primary",
                        SupportTicketStatus::ANSWERED => "info",
                        default => "primary"
                    };
                    
                    return "<div class=\"badge badge-$color  badge-outline\">$status</div>";
                })
                ->addColumn("action", function ($ticket) {
                    return SupportTicketTableAction::getInstance($ticket)->button();
                })

                ->rawColumns(['priority', 'status', 'action'])
                ->make(true);
        }

        return view('admin.tickets.answered');
    }

    /**
     * Get Closed Tickets List
     * @return mixed
     */
    public function closed(): mixed
    {
        if (IS_API_REQUEST) {
            $tickets = SupportTicket::closed()->latest()->with('replies')->get();
            return DataTables::of($tickets)

                ->addColumn("user", function ($ticket) {
                    return $ticket->user?->first_name . " " . $ticket->user?->last_name;
                })
                ->editColumn("created_at", function ($ticket) {
                    return date('Y-m-d', strtotime($ticket->created_at));
                })
                ->editColumn("priority", function ($ticket) {
                    $priority = _t($ticket->priority->value);
                    $priority = strtoupper($priority);

                    $color = match ($ticket->priority) {
                        SupportTicketPriority::HIGH   => "error",
                        SupportTicketPriority::LOW    => "ghost",
                        SupportTicketPriority::MEDIUM => "info",
                        default => "primary"
                    };

                    return "<div class=\"badge badge-$color  badge-outline\">$priority</div>";
                })
                ->editColumn("status", function ($ticket) {
                    $status = _t($ticket->status->value);
                    $status = strtoupper($status);

                    $color  = match ($ticket->status) {
                        SupportTicketStatus::PENDING  => "primary",
                        SupportTicketStatus::CLOSED   => "ghost",
                        SupportTicketStatus::OPEN     => "primary",
                        SupportTicketStatus::ANSWERED => "info",
                        default => "primary"
                    };
                    
                    return "<div class=\"badge badge-$color  badge-outline\">$status</div>";
                })
                ->addColumn("action", function ($ticket) {
                    return SupportTicketTableAction::getInstance($ticket)->button();
                })

                ->rawColumns(['priority', 'status', 'action'])
                ->make(true);
        }

        return view('admin.tickets.closed',);
    }

    /**
     * View Details Tickets
     * @param string $ticket
     * @return mixed
     */
    public function show(string $ticket): mixed
    {
        return Response::send(
            response : $this->service->getTicketDetailsPageData($ticket),
            route    : back(),
            view     : "admin.tickets.details"
            // view     : view("user.support.details", ($response['data'] ?? []))
        );
    }

    /**
     * Reply To Ticket
     * @param \App\Http\Requests\User\ReplaySupportTicketRequest $request
     * @return mixed
     */
    public function reply(ReplaySupportTicketRequest $request): mixed
    {
        return Response::send(
            response : $this->service->replayToTicket($request),
            route    : route('adminTicketsShow', $request->ticket),
            //view     : "admin.tickets.details"
        );
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
            route    : "adminTicketsPending",
        );
    }
}
