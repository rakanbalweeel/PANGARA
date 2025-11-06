<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreSetting;

class StoreSettingController extends Controller
{
    // Get current store settings (single row)
    public function show()
    {
        $setting = StoreSetting::first();
        if (!$setting) {
            $setting = StoreSetting::create([]);
        }
        return response()->json($setting);
    }

    // Update store settings
    public function update(Request $request)
    {
        $setting = StoreSetting::first();
        if (!$setting) {
            $setting = StoreSetting::create([]);
        }
        $setting->update($request->only([
            'store_name', 'address', 'phone',
            'notif_email', 'notif_stock', 'notif_daily_report'
        ]));
        return response()->json(['success' => true, 'data' => $setting]);
    }
}
