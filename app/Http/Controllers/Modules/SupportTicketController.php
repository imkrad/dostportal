<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Services\SupportTicket\TicketClass;
use App\Services\SupportTicket\DropdownClass;
use App\Http\Requests\HrRequest;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;

class SupportTicketController extends Controller
{
    use HandlesTransaction;

    public function __construct(TicketClass $ticket, DropdownClass $dropdown){
        $this->ticket = $ticket;
        $this->dropdown = $dropdown;
    }

    public function index(Request $request){
        switch($request->option){
            case 'support-tickets':
                return $this->ticket->lists($request);
            break;
            break;
            default:
                return inertia('Modules/Support-Ticket/Tickets/Index', [
                    'dropdowns' => [
                        'systems' => $this->dropdown->systems(),
                    ]
                ]); 
        }   
    }

   
}
