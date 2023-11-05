<?php

namespace App\Http\Controllers\Frontend;

use App\Helper\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\NewsletterSubscriptionVerification;
use App\Models\NewsletterSubscriber;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
    public function newsletterRequest(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $formerSubscriber = NewsletterSubscriber::where('email', $request->email)->first();
        if(!empty($formerSubscriber) && $formerSubscriber->count()>0){
            if($formerSubscriber->is_verified == 0){
                if(now()->diffInMinutes($formerSubscriber->sent_at) < 5){
                    return response(['status' => 'error', 'message' => 'You Should Have Received Your Email! Come Back Later For Re-Send']);
                }else{
                    $this->sendVerificationMail($formerSubscriber, $request);
                    return response(['status' => 'success', 'message' => 'We Had Re-Sent Your Verification Email']);
                }
            }elseif($formerSubscriber->is_verified == 1){
                return response(['status' => 'error', 'message' => 'You Are Already Subscribed']);
            }
        }else{
            $newSubscriber = new NewsletterSubscriber();
            $this->sendVerificationMail($newSubscriber, $request);
            return response(['status' => 'success', 'message' => 'Please Check Your Email For Verification Link']);
        }
    }

    public function sendVerificationMail(NewsletterSubscriber $subscriber, Request $request)
    {
        $subscriber->email = $request->email;
        $subscriber->verified_token = getToken(15);
        $subscriber->is_verified = 0;
        $subscriber->save();
        //set site mail config
        MailHelper::setMailConfig();
        //send email
        Mail::to($subscriber->email)->send(new NewsletterSubscriptionVerification($subscriber));
        $subscriber->sent_at = now();
        $subscriber->save();
    }

    public function newsletterEmailVerification($token)
    {
        $subscriber = NewsletterSubscriber::where('verified_token', $token)->first();
        if($subscriber){
            $subscriber->verified_token = 1;
            $subscriber->is_verified = 1;
            $subscriber->verified_at = now();
            $subscriber->save();
            toastr('You Have Verified Your Email!', 'success', 'success');
            flash('You Have Verified Your Email!', 'success');
            return redirect()->route('home');
        }else{
            toastr('Something Went Wrong', 'error', 'Error');
            flash('Something Went Wrong', 'error');
            return redirect()->route('home');
        }
    }
}
