<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function store(Request $req) {
        $val = $req->validate(['email' => 'required|email']);

        $found = Subscriber::where('email', '=', $req->email)->first();

        if (!$found) {
            
            Subscriber::create(['email' => $req->email]);
            
            return redirect()->route('home')->withErrors(['sent' => 'Subscribed Sucessfully!']);

        } else {

            return redirect()->route('home')->withErrors(['email' => 'Already Subscribed!']);

        }
    }
}
