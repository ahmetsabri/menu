<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = \App\Models\User::factory()->hasRestaurants()->create();

        $this->restaurant = $this->user->restaurants()->first();
    }

    public function test_can_create_category(): void
    {
        Storage::fake('public');
        $this->assertEquals(1, $this->user->restaurants()->count());
        $categoriesCount = $this->restaurant->categories()->count();
        $payload = [
            'name' => 'Pizza',
            'image' => UploadedFile::fake()->image('pizza.jpg')
        ];

        $this->actingAs($this->user)
            ->post((route('category.store', $this->user->restaurants->first())), $payload)
            ->assertRedirect();


        $this->assertDatabaseHas('categories', ['name' => $payload['name']]);
        $this->assertEquals($categoriesCount + 1, $this->restaurant->categories()->count());
        $this->assertNotNull(Image::first()->path);
        Storage::disk('public')->assertExists(Image::first()->path);
    }

    public function test_can_update_category()
    {
        Storage::fake('public');
        $this->assertEquals(1, $this->user->restaurants()->count());

        $categoriesCount = $this->restaurant->categories()->count();

        $this->assertEquals($categoriesCount, $this->user->restaurants()->first()->categories()->count());

        $payload = [
            'name' => 'Pizza',
            'image' => UploadedFile::fake()->image('pizza.jpg')
        ];

        $this->actingAs($this->user)
            ->post((route(
                    'category.update',
                    [
                        $this->user->restaurants->first(),
                        $this->user->restaurants->first()->categories->first()
                    ]
                )),
                $payload
            )
            ->assertRedirect();

            $this->assertDatabaseHas('categories', ['name' => 'Pizza']);
            $this->assertNotNull($this->user->restaurants()->first()->categories->first()->image);
            Storage::disk('public')->assertExists(Image::first()->path);
    }

    public function test_delete_category(){
        $this->restaurant->first()->categories()->create([
            'name' => fake('tr')->word(),
        ]);

        $this->assertGreaterThan(1, $this->user->restaurants()->first()->categories()->count());
        $this->actingAs($this->user)
        ->delete((route(
                'category.destroy',
                [
                    $this->user->restaurants->first(),
                    $this->user->restaurants->first()->categories->first()
                ]
            )),
        )
        ->assertRedirect();


    }
}
