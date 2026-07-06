<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function upgrade(Request $request)
    {
        $request->user()->update(['subscription_tier' => 'plus']);
        return back()->with('success', 'Mode Plus telah diaktifkan! Sekarang kamu bisa menambahkan musik latar ke undangan.');
    }

    public function downgrade(Request $request)
    {
        $request->user()->update(['subscription_tier' => 'free']);
        return back()->with('success', 'Mode Plus dinonaktifkan.');
    }
}
