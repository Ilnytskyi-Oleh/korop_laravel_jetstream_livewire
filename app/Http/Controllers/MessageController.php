<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Message;
use App\Notifications\ListingMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class MessageController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate(['message' => 'required']);

        $listing = Listing::with('user')->findOrFail($request->listing_id);


        $sentMessadges = Message::where('user_id', auth()->id())
            ->where('created_at', '>', now()->subMinute())
            ->count();

        if($sentMessadges < 5) {
            //Save message
            Message::create([
                'user_id' => auth()->id(),
                'message' => $request->message,
                'listing_id' => $request->listing_id,
            ]);
        }

        //Send message
        $message = [
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
            'listingTitle' => $listing->title,
            'messageText' => $request->message,
        ];

        Notification::route('mail', $listing->user->email)
            ->notify(new ListingMessageNotification($message));


        return redirect()->route('listings.index')->with('message','Message has been sent');
    }


}
