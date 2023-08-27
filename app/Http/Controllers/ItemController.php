<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant, Category $category)
    {
        $items = $category->items;
        return view('items.index', compact('restaurant', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreItemRequest $request, Restaurant $restaurant, Category $category)
    {
        $this->authorize('create', [Item::class, $restaurant,$category]);
        $category->items()->create($request->validated());

        return back()->with('success', __('messages.sucess_operation'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('update', [Item::class, $restaurant,$category,$item]);

        return view('items.edit', compact('restaurant', 'category', 'item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateItemRequest $request,Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('update', [Item::class, $restaurant,$category,$item]);
        $item->update($request->validated());

        return back()->with('success', __('messages.sucess_operation'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('delete', [Item::class, $restaurant, $category, $item]);
        $item->delete();

        return back()->with('success', __('messages.sucess_operation'));
    }
}
