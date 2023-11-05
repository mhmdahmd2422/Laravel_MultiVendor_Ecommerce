<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\NewsletterSubscriberDataTable;
use App\Helper\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\Newsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscribersController extends Controller
{
    public function index(NewsletterSubscriberDataTable $dataTable)
    {
        return $dataTable->render('admin.newsletter.index');
    }

    public function destroy(string $id)
    {
        $subscriber = NewsletterSubscriber::findOrFail($id);
        $subscriber->delete();

        return response(['status' => 'success', 'message' => 'Subscriber Deleted']);
    }

    public function sendNewsletter(Request $request)
    {
        $request->validate([
           'subject' => ['required', 'string', 'max:150'],
           'message' => ['required', 'string']
        ]);

        $subscribers = NewsletterSubscriber::verified()->pluck('email')->toArray();
        //set site mail config
        MailHelper::setMailConfig();
        Mail::to($subscribers)->send(new Newsletter($request->subject, $request->message));
        toastr('Mail Has Been Sent To Subscribers', 'success', 'success');
        flash('Mail Has Been Sent To Subscribers', 'success');

        return redirect()->back();
    }
}
