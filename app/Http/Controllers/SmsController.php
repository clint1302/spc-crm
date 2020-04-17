<?php

namespace App\Http\Controllers;

use App\SmsSetting;
use App\User;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('administrator.sms.sms');
    }

    public function individual(Request $request)
    {
        $this->validate(request(), [
            'number' => 'required|max:20',
            'message' => 'required',
        ]);

        $sms_setting = SmsSetting::orderBy('id', 'desc')->first();

        //SMS Code
        $api_key = $sms_setting->api_key;
        $contacts = $request->get('number');
        $from = $sms_setting->sms_from;
        $sms_text= $request->get('message');
        $sms_text = urlencode($sms_text);

        //Submit to server
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $sms_setting->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&routeid=".$sms_setting->routeid."&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);

        if(!empty($response)){
            return redirect()->back()->with('message', 'Send successfully. If not please check your sms setting.');
        }else{
            return redirect()->back()->with('exception', 'Operation failed !');
        }
    }

    public function group(Request $request)
    {
     $this->validate(request(), [
        'group_id' => 'required',
        'message' => 'required',
    ],[
       'group_id.required' => 'The group name field is required.',
   ]);

     $sms_setting = SmsSetting::orderBy('id', 'desc')->first();
     $users = User::where('access_label', $request->get('group_id'))
     ->where('deletion_status', 0)
     ->where('activation_status', 1)
     ->select('contact_no_one', 'name')
     ->get();

     foreach($users as $user){
        //SMS Code
        $api_key = $sms_setting->api_key;
        $contacts = $user->contact_no_one;
        $from = $sms_setting->sms_from;
        $sms_text= 'Hello ' . $user->name . ', ' . $request->get('message');
        $sms_text = urlencode($sms_text);

        //Submit to server
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $sms_setting->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&routeid=".$sms_setting->routeid."&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    return redirect()->back()->with('message', 'Send successfully. If not please check your sms setting.');
}
}
