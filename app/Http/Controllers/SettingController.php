<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = new Setting();
        $tax = $setting->getSetting('tax');
        $data['tax'] = $tax;

        return view('backend.setting.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'tax'    => 'required|numeric',
        ],
        [
            'tax.required'    => 'Tax must not be empty',
            'tax.numeric'     => 'Tax must be a number',
        ]);      

        $tax = [
            'key'   => 'tax',
            'value' => $request->tax,
        ];

        $data['tax'] = $tax;

        $setting = new Setting();
        $setting->setSetting($data);

        return redirect()->back()->with('success', 'Setting Stored Successfully!');
    }
}
