<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Restaurant;
use App\Http\Requests\StoreItemRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateItemRequest;

class ItemController extends Controller
{
    public function index(Restaurant $restaurant, Category $category)
    {
        return view('items.index', compact('restaurant', 'category'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(StoreItemRequest $request, Restaurant $restaurant, Category $category)
    {
        $this->authorize('create', [Item::class, $restaurant,$category]);
        $item = $category->items()->create($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items');
            $item->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.sucess_operation'));
    }

    public function edit(Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('update', [Item::class, $restaurant,$category,$item]);

        return view('items.edit', compact('restaurant', 'category', 'item'));
    }

    public function update(UpdateItemRequest $request,Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('update', [Item::class, $restaurant,$category,$item]);

        $item->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {

            $item->image ? Storage::delete($item?->image?->path ?? '') : '';
            $path = $request->file('image')->store('items');

            $item->image ? $item->image()->update(['path' => $path]) : $item->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.sucess_operation'));
    }

    public function destroy(Restaurant $restaurant, Category $category, Item $item)
    {
        $this->authorize('delete', [Item::class, $restaurant, $category, $item]);

        $item->delete();

        return request()->expectsJson() ? response()->json(status: 204) :
            back()->with('success', __('messages.sucess_operation'));
    }
}
