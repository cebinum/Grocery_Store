<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_add_new_product_test()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->make();
        $data = [
            'id' => $this->faker->uniqid,
            'name' => $this->faker->sentence,
            'quantity' => $this->faker->randomDigit,
            'slug' => Str::slug($this->faker->sentence),
            'unit_and_price' => $this->faker->randomDigit(),
            'photo' => $this->faker->imageUrl(),
            'category_id' => 1,
        ];

        $this->actingAs($user)->post(route('products.store', $data))
            ->assertSuccessful();
    }

    public function test_show_new_user_test()
    {
        $this->assertTrue(true);
    }
}
