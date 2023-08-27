<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $restaurants = auth()->user()->load('restaurants')->loadCount('restaurants');

        return view('restaurants.index', compact('restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = auth()->user()->restaurants()->create($request->safe()->except('image'));

        if($request->hasFile('image')){
            $path = $request->file('image')->store('restaurants');
            $restaurant->image()->create(['path' => $path]);
        }

        return to_route('restaurant.show', $restaurant)->with('success', __('messages.restaurant_created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('categories')->loadCount('categories');

        return view('restaurants.show', compact('restaurant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);

        $restaurant = $restaurant->load('categories')->loadCount('categories');

        return view('restaurants.edit', compact('restaurant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $this->authorize('update', $restaurant);
        $restaurant = $restaurant->load('image');

        $restaurant->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {

            $restaurant->image ? Storage::delete($restaurant?->image?->path ?? '') : '';
            $path = $request->file('image')->store('restaurants');

            $restaurant->image ? $restaurant->image()->update(['path' => $path]) : $restaurant->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.restaurant_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant)
    {
        $this->authorize('delete', $restaurant);

        $restaurant->delete();

        return back()->with('success', __('messages.restaurant_deleted'));
    }
}
