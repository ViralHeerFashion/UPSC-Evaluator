<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function create(Request $request)
    {
        $contact_us = new ContactUs;
        $contact_us->first_name = $request->first_name;
        $contact_us->last_name = $request->last_name;
        $contact_us->email = $request->email;
        $contact_us->phone = $request->phone;
        $contact_us->message = $request->message;
        $contact_us->save();

        return back()->with('success', "Message send successfully..");
    }
}
