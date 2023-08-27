<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Item $item): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Restaurant $restaurant, Category $category): bool
    {
        return $restaurant->created_by === $user->id && $category->restaurant_id === $restaurant->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Restaurant $restaurant, Category $category, Item $item): bool
    {
        return $restaurant->created_by === $user->id &&
            $category->restaurant_id === $restaurant->id &&
            $item->category_id === $category->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Restaurant $restaurant, Category $category, Item $item): bool
    {
        return $restaurant->created_by === $user->id &&
            $category->restaurant_id === $restaurant->id &&
            $item->category_id === $category->id;
    }
}
