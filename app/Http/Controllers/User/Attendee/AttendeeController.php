<?php

namespace App\Http\Controllers\User\Attendee;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttendeeRequest;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    // public function store(AttendeeRequest $request) {
    //     $attendee = Attendee::create($request->all());
    //     return response()->json([
    //         "status" => true,
    //         "message" => "Attendee created successfully",
    //         "Attendee" => $attendee
    //     ]);
    // }

    public function destroy(string $id) {
        $attendee = Attendee::findOrFail($id);
    
        if ($attendee) {
            
            if ($attendee->user) {
                $attendee->user->delete();
            }
    
            $attendee->delete();
            return response()->json([
                "status" => true,
                "message" => "Attendee and associated user deleted successfully",
                "attendee" => $attendee
            ]);
        } else {
            return response()->json([
                "message" => "Attendee ID not found"
            ], 404);
        }
    }

    public function list(Request $request, $id = null) {
        if($id) {
            $attendee = Attendee::find($id);
            if($attendee){
                return response()->json([
                    "message" => "Attendee list",
                    "Attendee" => $attendee
                ]);
            } else {
                return response()->json([
                    "message" => "No attendee with this ID"
                ],404);
            }
        }
        else {
            $attendee = Attendee::all();
            if(!$attendee->isEmpty()) {
                return response()->json([
                    "message" => "Attendees list",
                    "Attendees" => $attendee
                ]);
            } else {
                return response()->json([
                    "message" => "No attendees found"
                ],404);
            }
        }
    }
}
