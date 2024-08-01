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
    // 見積もりを取得
    $estimates = Estimate::with('customer')->get();

    // 最新バージョンの見積もりアイテムを取得し、見積もりIDごとにグループ化
    $latestEstimateItems = Estimate_item::select('estimate_id', 'diff', 'effort', 'acc', 'cost', 'risk')
        ->whereIn('version', function($query) {
            $query->selectRaw('MAX(version)')
                ->from('estimate_items')
                ->groupBy('estimate_id');
        })
        ->get()
        ->groupBy('estimate_id');

    // 各見積もりの合計金額を計算
    $estimates = $estimates->map(function($estimate) use ($latestEstimateItems) {
        $items = $latestEstimateItems->get($estimate->id, collect());
        $totalCost = $items->sum(function($item) {
            $baseCost = $item->diff * $item->effort;
            $adjustedCost = $baseCost * ($item->acc / 100 + 1) * ($item->cost / 100 + 1) * ($item->risk / 100 + 1);
            return $adjustedCost;
        });
        $estimate->item = $items;
        $estimate->total_cost = $totalCost;
        return $estimate;
    });

    return view('estimates.index', compact('estimates'));
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
            'issue_date', 'limit_date', 'memo', 'user_id',
            'issued', 'ordered', 'on_hold'
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
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estimate = Estimate::findOrFail($id);
        $customer = Customer::findOrFail($estimate->customer_id);
        $items = Estimate_item::where('estimate_id', $id)
            ->where('version', function ($query) use ($id) {
                $query->selectRaw('MAX(version)')
                    ->from('estimate_items')
                    ->where('estimate_id', $id);
            })
            ->with('item')
            ->get();

        return view('estimates.edit', compact('estimate', 'customer', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 見積もりの更新
        $estimate = Estimate::findOrFail($id);
        $data = $request->only([
            'name', 'customer_id', 'person',
            'issue_date', 'limit_date', 'memo', 'user_id',
            'issued', 'ordered', 'on_hold'
        ]);
        // デフォルト値を設定
        $data['issued'] = $request->has('issued') ? $request->issued : false;
        $data['ordered'] = $request->has('ordered') ? $request->ordered : false;
        $data['on_hold'] = $request->has('on_hold') ? $request->on_hold : false;
        $estimate->update($data);

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
     * Display the specified resource.
     */
    public function show(string $id, ?int $version = null)
    {
        $estimate = Estimate::findOrFail($id);
        $version = $version ?? Estimate_item::where('estimate_id', $id)->max('version');

        $items = Estimate_item::where('estimate_id', $id)
            ->where('version', $version)
            ->with('item')
            ->get();

        $customer = Customer::findOrFail($estimate->customer_id);

        return view('estimates.show', compact('estimate', 'items', 'customer', 'version'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function statusUpdate(Request $request, string $id)
    {
        $estimate = Estimate::findOrFail($id);
        $estimate->update($request->only(['issued', 'ordered', 'on_hold']));

        return redirect()->route('estimate.show', $id);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estimate = Estimate::findOrFail($id);
        $estimate->delete(); // ここで論理削除を実行
        return redirect()->route('estimate.index');
    }
}
