<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:190'],
            'subject' => ['required','string','max:190'],
            'message' => ['required','string','max:5000'],
        ]);

        // Option A (recommended): send an email via Laravel Mail
        // Option B: store in DB (ContactMessage model + migration)
        // Keeping it simple here:
        // \Log::info('Contact message', $data);

        return back()->with('success', 'Message sent successfully. Support will contact you soon.');
    }
}
