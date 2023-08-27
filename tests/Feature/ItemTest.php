<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->hasRestaurants()->create();
        $this->restaurant = $this->user->restaurants->first();
        $this->category = $this->restaurant->categories()->first();
    }

    public function test_can_create_new_item(): void
    {
        $this->assertEquals(0, $this->category->items()->count());
        $this->assertEquals(0, $this->restaurant->items()->count());
        $response = $this->actingAs($this->user)
            ->post(route('item.store', [$this->restaurant, $this->category]), [
                'title' => 'New Item',
                'description' => 'New Item Description',
                'price' => 1000,
            ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();
        $this->assertEquals(1, $this->category->items()->count());
        $this->assertEquals(1, $this->restaurant->items()->count());
        $this->assertDatabaseHas('items', [
            'title' => 'New Item',
            'description' => 'New Item Description',
            'price' => 1000,
        ]);
    }

    public function test_can_update_item(){
        $this->category->items()->create([
            'title' => 'New Item',
            'description' => 'New Item Description',
            'price' => 1000,
        ]);

        $this->assertEquals(1, $this->category->items()->count());

        $response = $this->actingAs($this->user)
            ->put(route('item.update', [$this->restaurant, $this->category, $this->category->items()->first()]), [
                'title' => 'Updated Item',
                'description' => 'Updated Item Description',
                'price' => 2000,
            ]);

        $response->assertRedirect();

        $response->assertSessionHasNoErrors();
    }

    public function test_can_delete_item(){
        $this->category->items()->create([
            'title' => 'New Item',
            'description' => 'New Item Description',
            'price' => 1000,
        ]);

        $this->assertEquals(1, $this->category->items()->count());


        $response = $this->actingAs($this->user)
            ->delete(route('item.destroy', [$this->restaurant, $this->category, $this->category->items()->first()]));
        $this->assertEquals(0, $this->category->fresh()->items()->count());
        $this->assertDatabaseEmpty('items');
    }

}
