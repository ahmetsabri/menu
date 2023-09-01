<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('categories');
        return view('categories.index', compact('restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request, Restaurant $restaurant)
    {
        $this->authorize('create', [Category::class, $restaurant]);

        $category = $restaurant->categories()->create($request->safe()->except('image'));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories');
            $category->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.succes_operation'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        //TODO: Load items with category
        $category = $category->load('items.image');

        return view('categories.show', compact('restaurant', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        $this->authorize('update', $category);
        return view('categories.edit', compact('restaurant', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        $category->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {

            $category->image ? Storage::delete($category?->image?->path ?? '') : '';
            $path = $request->file('image')->store('categories');

            $category->image ? $category->image()->update(['path' => $path]) : $category->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.succes_operation'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant, Category $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return back()->with('success', __('messages.succes_operation'));
    }
}
