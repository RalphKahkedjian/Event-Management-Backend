<?php

namespace App\Http\Controllers\User\Booking;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use App\Models\Booking;

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
    
        $existingBooking = Booking::where('ticket_id', $request->input('ticket_id'))
                                    ->where('attendee_id', $attendee->id)
                                    ->first();
    
        if ($existingBooking) {
            return response()->json([
                "status" => false,
                "message" => "You have already booked this ticket."
            ], 409);
        }
    
        $booking = new Booking();
        $booking->ticket_id = $request->input('ticket_id');
        $booking->attendee_id = $attendee->id;
        $booking->spots = $request->input('spots');
        $booking->status = 'available';
        $booking->save();

        $booking->status = "booked";
        $booking->save();
    
        return response()->json([
            "status" => true,
            "message" => "Booked Successfully",
            "Booking" => $booking
        ], 200);
    }
    
    
    
}
