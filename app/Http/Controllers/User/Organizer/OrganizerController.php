<?php

namespace App\Http\Controllers\User\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizerRequest;
use App\Models\Organizer;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{

    // You can  keep the store function but I used it in the AuthController directly to store
    //depending on the role entered by the user
    
    // public function store(OrganizerRequest $request) {
    //     $organizer = Organizer::create($request->all());
    //     return response()->json([
    //         "status" => true,
    //         "message" => "Organizer created successfully",
    //         "Organizer" => $organizer
    //     ]);
    // }

    public function destroy(string $id) {
        $organizer = Organizer::findOrFail($id);
        if($organizer){
            $organizer->delete();
            return response()->json([
                "status" => true,
                "message" => "Organizer deleted successfully",
                "Organizer" => $organizer
            ]);
        }
        else {
            return response()->json([
                "status" => false,
                "message" => "Organizer ID not found"
            ]);
        }
    }

    public function list(Request $request, $id = null) {
        if ($id) {
            $organizer = Organizer::find($id);
            if ($organizer) {
                return response()->json([
                    "message" => "Organizer found",
                    "organizer" => $organizer
                ]);
            } else {
                return response()->json([
                    "message" => "No organizer found with this ID"
                ], 404);
            }
        } else {
            $organizers = Organizer::all();
            if ($organizers->isNotEmpty()) {
                return response()->json([
                    "message" => "List of organizers",
                    "organizers" => $organizers
                ]);
            } else {
                return response()->json([
                    "message" => "No organizers found"
                ], 404);
            }
        }
    }
    
}
