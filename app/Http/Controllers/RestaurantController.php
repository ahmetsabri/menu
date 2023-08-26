<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Restaurant;

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
        auth()->user()->restaurants()->create($request->validated());

        return back()->with('success', __('messages.restaurant_created'));
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

        $restaurant->update($request->validated());

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
