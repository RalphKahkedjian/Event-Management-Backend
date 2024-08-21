<?php

namespace App\Http\Controllers\User\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Ticket;

class BookingController extends Controller
{
    public function store(BookingRequest $request)
    {
        $user = auth()->user();
    
        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "Please log in"
            ], 401);
        }
    
        if ($user->role !== "attendee") {
            return response()->json([
                "status" => false,
                "message" => "You are an organizer, you can't book! (You can create a new attendee account)"
            ], 403);
        }
    
        $attendee = $user->attendee;
        if (!$attendee) {
            return response()->json([
                "status" => false,
                "message" => "Attendee record not found for the user."
            ], 404);
        }
    
        // Check if the user has already booked this ticket
        $existingBooking = Booking::where('ticket_id', $request->input('ticket_id'))
                                    ->where('attendee_id', $attendee->id)
                                    ->first();
    
        if ($existingBooking) {
            return response()->json([
                "status" => false,
                "message" => "You have already booked this ticket."
            ], 409);
        }
    
        // Find the ticket
        $ticket = Ticket::find($request->input('ticket_id'));
        if (!$ticket) {
            return response()->json([
                "status" => false,
                "message" => "Ticket not found."
            ], 404);
        }
    
        // Check if there are available spots
        if ($ticket->spots <= 0) {
            return response()->json([
                "status" => false,
                "message" => "No spots left for this ticket."
            ], 409);
        }
    
        // Proceed with booking
        $booking = new Booking();
        $booking->ticket_id = $request->input('ticket_id');
        $booking->attendee_id = $attendee->id;
        $booking->save();
    
        // Update the ticket's spots and status
        $ticket->spots -= 1;
        $ticket->status = $ticket->spots > 0 ? "available" : "booked";
        $ticket->save();
    
        return response()->json([
            "status" => true,
            "message" => "Booked Successfully",
            "Booking" => $booking
        ], 200);
    }
    
    
    public function list() {
        $bookings = Booking::with('ticket')->get();
        if($bookings->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "Bookings list is empty"
            ]);
        }

        $bookingsData = $bookings->map(function($booking){
            return [
                "booking_id" => $booking->id,
                "status" => $booking->status,
                "ticket" => [
                    "id" => $booking->ticket->id,
                    "place" => $booking->ticket->place,
                    "time" => $booking->ticket->time,
                    "price" => $booking->ticket->price

                ]
            ];
        });

        return response()->json([
            "status" => true,
            "message" => "Bookings list",
            "booking" => $bookingsData
        ]);
    }
    
    
}
