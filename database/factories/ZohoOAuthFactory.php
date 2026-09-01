<?php

declare(strict_types=1);

namespace Simtabi\Laranail\CrmTools\ZohoOAuth\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Simtabi\Laranail\CrmTools\ZohoOAuth\Models\ZohoOauth;

class ZohoOAuthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ZohoOauth::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'refresh_token' => Str::random(32),
            'access_token' => Str::random(40),
            'expires_at' => now()->addMinutes(50),
        ];
    }

    /**
     * Indicate if a token is recent.
     *
     * @return Factory
     */
    public function recent()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->subMinutes(rand(1, 60)),
            ];
        });
    }

    /**
     * Indicate if a token is old.
     *
     * @return Factory
     */
    public function old()
    {
        return $this->state(function (array $attributes) {
            return [
                'created_at' => now()->subDays(rand(4, 10)),
            ];
        });
    }

    /**
     * Indicate if a token is valid.
     *
     * @return Factory
     */
    public function valid()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => now()->addMinutes(rand(20, 50)),
            ];
        });
    }

    /**
     * Indicate if a token is expired.
     *
     * @return Factory
     */
    public function expired()
    {
        return $this->state(function (array $attributes) {
            return [
                'expires_at' => now()->subMinutes(rand(20, 50)),
            ];
        });
    }
}
