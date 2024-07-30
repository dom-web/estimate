<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\DefaultSetting;

class ItemController extends Controller
{
    // 一覧表示
    public function index()
    {
        $items = Item::all();
        return view('items.index', compact('items'));
    }

    // 新規作成フォーム表示
    public function create()
    {
        $defaults = DefaultSetting::first(); // 初期値を取得
        return view('items.create', compact('defaults'));
    }

    // 新規作成処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            // 必要なバリデーションを追加
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')
                        ->with('success', 'Item created successfully.');
    }

    // 編集フォーム表示
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    // 更新処理
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            // 必要なバリデーションを追加
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
                        ->with('success', 'Item updated successfully.');
    }

    // 削除処理
    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
                        ->with('success', 'Item deleted successfully.');
    }

    public function select()
    {
        $items = Item::all();
        return view('partials.item-options', compact('items'));
    }

    public function show(Request $request)
    {
        $id = $request->get('id');
        $items = Item::all();
        $selected = Item::findOrFail($id);
        return view('partials.item-details', compact('selected','items'));
    }

    public function getItemBox()
    {
        $items = Item::all();
        return view('partials.item-box', compact('items'));
    }
}
