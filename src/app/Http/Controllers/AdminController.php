<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DefaultSetting;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

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

        DefaultSetting::truncate(); // 既存のデータを削除
        DefaultSetting::create($data); // 新しいデータを挿入

        return redirect()->route('admin.dashboard')->with('status', 'Defaults updated successfully!');
    }
}
