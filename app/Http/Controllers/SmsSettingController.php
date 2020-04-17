<?php

namespace App\Http\Controllers;

use App\SmsSetting;
use Illuminate\Http\Request;

class SmsSettingController extends Controller
{

    public function index()
    {
        $sms_setting = SmsSetting::orderBy('id', 'desc')->first();
        return view('administrator.setting.sms.edit', compact('sms_setting'));
    }

    public function update(Request $request, $id)
    {
        $sms_setting = SmsSetting::find($id);

        request()->validate([
            'sms_from' => 'required|max:11',
            'api_key' => 'required|max:250',
            'routeid' => 'required|max:250',
            'url' => 'required|max:250|',
        ], [
            'sms_from.required' => 'The sms from field is required.',
        ]);

        $sms_setting->sms_from = $request->get('sms_from');
        $sms_setting->api_key = $request->get('api_key');
        $sms_setting->routeid = $request->get('routeid');
        $sms_setting->url = $request->get('url');

        $affected_row = $sms_setting->save();

        if (!empty($affected_row)) {
            return redirect()->back()->with('message', 'Update successfully.');
        }
        return redirect()->back()->with('exception', 'Operation failed !');
    }
}
