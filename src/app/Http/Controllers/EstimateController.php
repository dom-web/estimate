<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estimate;
use App\Models\Estimate_item;
use App\Models\Item;
use App\Models\Customer;


class EstimateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('home', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 見積もりの保存
        $estimate = Estimate::create($request->only([
            'name', 'customer_id', 'person',
            'issue_date', 'limit_date', 'memo', 'user_id'
        ]));

        // 見積もりアイテムの保存
        foreach ($request->items as $itemData) {
            Estimate_item::create([
                'estimate_id' => $estimate->id,
                'version' => 1,
                'item_id' => $itemData['item_id'],
                'diff' => $itemData['diff'],
                'acc' => $itemData['acc'],
                'cost' => $itemData['cost'],
                'risk' => $itemData['risk'],
                'effort' => $itemData['effort'],
            ]);
        }

        return redirect()->route('estimate.show', $estimate->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estimate = Estimate::findOrFail($id);
        $items = Estimate_item::where('estimate_id', $id)
        ->where('version', function($query) use ($id) {
            $query->selectRaw('MAX(version)')
                ->from('estimate_items')
                ->where('estimate_id', $id);
        })
        ->get();

        return view('show-estimate', compact('estimate', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estimate = Estimate::findOrFail($id);
        return view('edit-estimate', compact('estimate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 見積もりの更新
        $estimate = Estimate::findOrFail($id);
        $estimate->update($request->only([
            'name', 'customer_id', 'person',
            'issue_date', 'limit_date', 'memo', 'user_id'
        ]));

        // 現在の最新バージョンを取得
        $latestVersion = Estimate_item::where('estimate_id', $id)->max('version');

        // 新しいバージョン番号を設定
        $newVersion = $latestVersion + 1;

        // 見積もりアイテムの保存
        foreach ($request->items as $itemData) {
            Estimate_item::create([
                'estimate_id' => $id,
                'version' => $newVersion,
                'item_id' => $itemData['item_id'],
                'diff' => $itemData['diff'],
                'acc' => $itemData['acc'],
                'cost' => $itemData['cost'],
                'risk' => $itemData['risk'],
                'effort' => $itemData['effort'],
            ]);
        }

        return redirect()->route('estimate.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
