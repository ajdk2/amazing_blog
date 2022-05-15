<?php

namespace App\Http\Controllers;

use App\Mail\ContactMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'phone_number' => 'required',
            'message' => 'required',
        ]);

        Mail::to('dequitoaljon@gmail.com')->send(new ContactMe($validated));

        return back()->with('status', 'Mail send!');
    }
}
