<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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
        $this->assertEquals(1, $this->user->restaurants()->count());

        $payload = [
            'name' => 'Pizza',
        ];

        $this->actingAs($this->user)
            ->post((route('category.store', $this->user->restaurants->first())), $payload)
            ->assertRedirect();


        $this->assertDatabaseHas('categories', $payload);
        $this->assertEquals(1, $this->user->restaurants()->first()->categories()->count());
    }

    public function test_can_update_category()
    {
        $this->assertEquals(1, $this->user->restaurants()->count());

        $this->restaurant->first()->categories()->create([
            'name' => fake('tr')->word(),
        ]);

        $this->assertEquals(1, $this->user->restaurants()->first()->categories()->count());

        $payload = [
            'name' => 'Pizza',
        ];

        $this->actingAs($this->user)
            ->put((route(
                    'category.update',
                    [
                        $this->user->restaurants->first(),
                        $this->user->restaurants->first()->categories->first()
                    ]
                )),
                $payload
            )
            ->assertRedirect();

            $this->assertDatabaseHas('categories', $payload);
    }

    public function test_delete_category(){
        $this->restaurant->first()->categories()->create([
            'name' => fake('tr')->word(),
        ]);

        $this->assertEquals(1, $this->user->restaurants()->first()->categories()->count());
        $this->actingAs($this->user)
        ->delete((route(
                'category.update',
                [
                    $this->user->restaurants->first(),
                    $this->user->restaurants->first()->categories->first()
                ]
            )),
        )
        ->assertRedirect();

        $this->assertEquals(0, $this->user->restaurants()->first()->categories()->count());

        $this->assertDatabaseEmpty('categories');
    }
}
