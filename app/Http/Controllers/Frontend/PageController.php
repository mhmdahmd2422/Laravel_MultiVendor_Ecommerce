<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\Contact;
use App\Models\About;
use App\Models\EmailConfiguration;
use App\Models\FooterData;
use App\Models\TermsAndConditions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about()
    {
        $about = About::first();
        return view('frontend.pages.about', compact('about'));
    }

    public function termsAndConditions()
    {
        $terms = TermsAndConditions::first();
        return view('frontend.pages.terms-and-conditions', compact('terms'));
    }

    public function contact()
    {
        $contact_data = FooterData::first();
        return view('frontend.pages.contact-us', compact('contact_data'));
    }

    public function handleContactForm(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email'],
            'subject' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:300'],
        ]);
        $mailSetting = EmailConfiguration::first();
        Mail::to($mailSetting->email)->send(new Contact($request->subject, $request->message, $request->email));

        return response(['status' => 'success', 'message' => 'Your Message Has Been Sent!']);
    }
}
