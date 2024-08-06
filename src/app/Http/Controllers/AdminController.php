<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefaultSetting;
use App\Models\Item;

class AdminController extends Controller
{

    public function index()
    {
        $defaults = DefaultSetting::first();
        return view('admin.dashboard', compact('defaults'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'diff_low' => 'required|integer',
            'diff_mid' => 'required|integer',
            'diff_high' => 'required|integer',
            'acc_low' => 'required|integer',
            'acc_mid' => 'required|integer',
            'acc_high' => 'required|integer',
            'cost_low' => 'required|integer',
            'cost_mid' => 'required|integer',
            'cost_high' => 'required|integer',
            'risk_low' => 'required|integer',
            'risk_mid' => 'required|integer',
            'risk_high' => 'required|integer',
        ]);

        DefaultSetting::create($data);

        return redirect()->route('admin.dashboard')->with('status', 'Defaults created successfully!');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'diff_low' => 'required|integer',
            'diff_mid' => 'required|integer',
            'diff_high' => 'required|integer',
            'acc_low' => 'required|integer',
            'acc_mid' => 'required|integer',
            'acc_high' => 'required|integer',
            'cost_low' => 'required|integer',
            'cost_mid' => 'required|integer',
            'cost_high' => 'required|integer',
            'risk_low' => 'required|integer',
            'risk_mid' => 'required|integer',
            'risk_high' => 'required|integer',
        ]);
        $oldValues  = DefaultSetting::first();

        DefaultSetting::truncate(); // 既存のデータを削除
        DefaultSetting::create($data); // 新しいデータを挿入

        Item::where('diff_low', $oldValues['diff_low'])
        ->orWhere('diff_mid', $oldValues['diff_mid'])
        ->orWhere('diff_high', $oldValues['diff_high'])
        ->orWhere('acc_low', $oldValues['acc_low'])
        ->orWhere('acc_mid', $oldValues['acc_mid'])
        ->orWhere('acc_high', $oldValues['acc_high'])
        ->orWhere('cost_low', $oldValues['cost_low'])
        ->orWhere('cost_mid', $oldValues['cost_mid'])
        ->orWhere('cost_high', $oldValues['cost_high'])
        ->orWhere('risk_low', $oldValues['risk_low'])
        ->orWhere('risk_mid', $oldValues['risk_mid'])
        ->orWhere('risk_high', $oldValues['risk_high'])
        ->update($request->only([
            'diff_low', 'diff_mid', 'diff_high',
            'acc_low', 'acc_mid', 'acc_high',
            'cost_low', 'cost_mid', 'cost_high',
            'risk_low', 'risk_mid', 'risk_high',
        ]));

        return redirect()->route('admin.dashboard')->with('status', 'Defaults updated successfully!');
    }
}
