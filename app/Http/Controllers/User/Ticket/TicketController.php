<?php

namespace App\Http\Controllers\User\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\TicketRequest;
use App\Models\Ticket;
use App\Models\Organizer;

class TicketController extends Controller
{
    public function store(TicketRequest $request) {
        
        $user = auth()->user();

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Unauthorized: Please log in"
            ], 401); 
        }

        if ($user->role !== 'organizer') {
            return response()->json([
                "status" => false,
                "message" => "You have no right to create tickets"
            ], 403); 
        }

        $organizer = Organizer::find($request->input('organizer_id'));

        if (!$organizer) {
            return response()->json([
                "status" => false,
                "message" => "Invalid organizer ID"
            ], 404);
        }

        if ($user->role === 'organizer') {
            if ($organizer->user_id !== $user->id)
            {
                return response()->json([
                    "status" => false,
                    "message" => "You are not authorized to create tickets for this organizer"
                ], 403);
            }
        } else {
            return response()->json([
                "status" => false,
                "message" => "You have no right to create tickets"
            ], 403);
        }
        $ticket = Ticket::create($request->validated());

        return response()->json([
            "status" => true,
            "message" => "Ticket created successfully",
            "ticket" => $ticket
        ], 201);
    }

    public function list(Request $request) {
        $tickets = Ticket::select('id', 'place', 'time', 'price', 'spots' , 'organizer_id', 'status')->get();
        
        return response()->json([
            "message" => "Listed Tickets",
            "tickets" => $tickets
        ], 200);
    }
    
}
