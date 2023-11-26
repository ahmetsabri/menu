<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function index(Restaurant $restaurant)
    {
        $restaurant = $restaurant->load('categories');
        return view('categories.index', compact('restaurant'));
    }

    public function create()
    {
        return view('categories.create');
    }

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

    public function show(Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        $category = $category->load('items.image');

        return view('categories.show', compact('restaurant', 'category'));
    }

    public function edit(Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        $this->authorize('update', $category);
        return view('categories.edit', compact('restaurant', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Restaurant $restaurant, Category $category)
    {
        abort_if($category->restaurant_id !== $restaurant->id, 404);

        $category->update($request->safe()->except('image'));

        if ($request->hasFile('image')) {

            $category->image ? Storage::delete($category?->image?->path ?? '') : '';
            $path = $request->file('image')->store('categories');

            $category->image ? $category->image()->update(['path' => $path])
                : $category->image()->create(['path' => $path]);
        }

        return back()->with('success', __('messages.succes_operation'));
    }

    public function destroy(Restaurant $restaurant, Category $category)
    {
        $this->authorize('delete', $category);

        $category = $category->load('items.image');

        $category->items->each(function ($item) {
            $item->delete();
        });

        $category->delete();

        return request()->expectsJson() ? response()->json(status:204)
         : back()->with('success', __('messages.sucess_operation'));
    }
}
