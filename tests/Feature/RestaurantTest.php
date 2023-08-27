<?php

namespace Tests\Feature;

use App\Models\Image;
use App\Models\Restaurant;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        Storage::fake('public');
        $this->assertCount(0, $this->user->restaurants);

        $response = $this->actingAs($this->user)->post('/restaurants', [
            'name' => 'My Restaurant',
            'image' => UploadedFile::fake()->image('restaurant.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('restaurants', 1);
        $this->assertCount(1, $this->user->fresh()->restaurants);
        $this->assertDatabaseHas('restaurants', [
            'name' => 'My Restaurant'
        ]);
        $response->assertSessionDoesntHaveErrors();
        $response->assertSessionHas('success');

        Storage::disk('public')->assertExists(Image::first()->path);
    }

    public function test_can_update_resturant()
    {
        Storage::fake('public');
        $this->actingAs($this->user);

        $restaurant =  $this->user->restaurants()->create(
            Restaurant::factory()->make()->toArray()
        );

        $response = $this->post('/restaurants/' . $restaurant->id, [
            'name' => 'new Restaurant',
            'image' => UploadedFile::fake()->image('restaurant.jpg'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseCount('restaurants', 1);
        $this->assertDatabaseHas('restaurants', [
            'name' => 'new Restaurant',
        ]);

        Storage::disk('public')->assertExists(Image::first()->path);
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
