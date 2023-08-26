<?php

namespace Tests\Feature;

use App\Models\Restaurant;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_create_restaurant(): void
    {
        $this->assertCount(0, $this->user->restaurants);
        $response = $this->actingAs($this->user)->post('/restaurants', [
            'name' => 'My Restaurant',
            'status' => 'active'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('restaurants', 1);
        $this->assertCount(1, $this->user->fresh()->restaurants);
        $this->assertDatabaseHas('restaurants', [
            'name' => 'My Restaurant'
        ]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas('success');
    }

    public function test_can_update_resturant()
    {
        $this->actingAs($this->user);

        $restaurant =  $this->user->restaurants()->create(
            Restaurant::factory()->make()->toArray()
        );

        $response = $this->put('/restaurants/' . $restaurant->id, [
            'name' => 'new Restaurant',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('restaurants', 1);
        $this->assertDatabaseHas('restaurants', [
            'name' => 'new Restaurant',
        ]);
    }

    public function test_delete_restaurant()
    {
        $this->actingAs($this->user);

        $restaurant =  $this->user->restaurants()->create(
            Restaurant::factory()->make()->toArray()
        );

        $response = $this->delete('/restaurants/' . $restaurant->id);

        $response->assertRedirect();
        $this->assertDatabaseCount('restaurants', 0);
    }
}
