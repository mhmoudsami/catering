<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\ContactMessage;
use App\Notifications\NewContactMessage as NewContactMessageNotification;

class ContactController extends Controller
{
    /**
     * create new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'mobile' => 'required',
            'email' => 'required|email',
            'message'  =>  'required|min:20',
       ]);

       if ($validator->fails()) {
            return response()->json([
                'status'    =>  false,
                'errors' => $validator->messages(),
            ]);
       }


        $message = ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'message' => $request->message,
        ]);

        if ( ! $message ) {
            return response()->json([
                'status'    =>  false,
                'errors' => [],
                "message" => 'some error happaened , try again later',
            ]);
        }

        # disable this notifications for now
        # you still have aproblem in sending mails locally
        $notifyable = User::whereJsonContains('notifications->contact_us', true)->active()->get();
        \Notification::send($notifyable, new NewContactMessageNotification($message));


        # order was created
        return response()->json([
            "status"    =>  true,
            "status_code" => Response::HTTP_OK,
        ]);
    }
}
