<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Toastr;
class ContactUsController extends Controller
{
    public function contactUs()
    {
        $siteSetting = SiteSetting::latest()->first();
        return view('user.pages.contact.contact-us',compact('siteSetting'));
    }

    public function storeMessage(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'subject' => 'required',
            ]);
            $message = new Message();
            $message->name = $request->name;
            $message->email = $request->email;
            $message->subject = $request->subject;
            $message->message = $request->message;
            $message->save();
            Toastr::success('Message Added Successfully', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
