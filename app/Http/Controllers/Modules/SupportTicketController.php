<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Services\SupportTicket\TicketClass;
use App\Services\SupportTicket\DropdownClass;
use App\Http\Requests\SupportTicketRequest;
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
            case 'support_tickets':
                return $this->ticket->lists($request);
            break;
            default:
                return inertia('Modules/Support-Ticket/Tickets/Index', [
                    'dropdowns' => [
                        'systems' => $this->dropdown->systems(),
                    ],
                ]); 
        }   
    }

    public function store(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'support-ticket':
                    return $this->ticket->save($request);
                break;
            }
        });
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(Request $request){
        $result = $this->handleTransaction(function () use ($request) {
            switch($request->option){
                case 'support-ticket':
                    return $this->ticket->update($request);
                break;
            }
        });
        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

   
}
