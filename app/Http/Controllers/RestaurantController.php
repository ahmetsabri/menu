<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;

class RestaurantController extends Controller
{
    public function index()
    {
        $restaurants = auth()->user()->load('restaurants')->loadCount('restaurants');

        return view('restaurants.index', compact('restaurants'));
    }

    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = auth()->user()->restaurants()->create($request->safe()->except('image'));

        if($request->hasFile('image')){
            $path = $request->file('image')->store('restaurants');
            $restaurant->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.success_operation'));
    }

    public function show(Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('categories.image');

        return view('restaurants.show', compact('restaurant'));
    }

    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $restaurant = $restaurant->load('categories')->loadCount('categories');

        return view('restaurants.edit', compact('restaurant'));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        $restaurant = $restaurant->load('image');

        $restaurant->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {

            $restaurant->image ? Storage::delete($restaurant?->image?->path ?? '') : '';
            $path = $request->file('image')->store('restaurants');

            $restaurant->image ? $restaurant->image()->update(['path' => $path])
                : $restaurant->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.restaurant_updated'));
    }

    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);
        $restaurant->image ? Storage::delete($restaurant?->image?->path ?? '') : '';

        $restaurant = $restaurant->load('categories.image')->load('items.image');

        foreach ($restaurant->items as $item) {
            $item->delete();
        }

        foreach ($restaurant->categories as $category) {
            $category->delete();
        }

        $restaurant->image()->delete();
        $restaurant->delete();

        return request()->expectsJson() ? response()->json(status: 204)
            : back()->with('success', __('messages.sucess_operation'));
    }
}
