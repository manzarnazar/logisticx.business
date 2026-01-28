<?php

namespace Database\Factories;

use App\Enums\UserType;
use App\Models\Backend\Merchant;
use App\Models\Backend\Upload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MerchantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Merchant::class;

    public function definition(): array
    {
        $avatar           = new Upload();
        $avatar->original = "backend/images/default/avatar/Avatar_" . rand(1, 4) . ".jpg";
        $avatar->save();

        $nid           = new Upload();
        $nid->original = "backend/images/default/card/blank_card_icon.jpg";
        $nid->save();

        $trade           = new Upload();
        $trade->original = "backend/images/default/card/trade_license.jpg";
        $trade->save();

        $user = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'mobile' => fake()->unique()->phoneNumber,
            'password' => Hash::make('12345678'),
            'address' => fake()->address,
            'hub_id' => rand(1, 3),
            'permissions' => [],
            'user_type' => UserType::MERCHANT,
            'nid_number' => rand(1111111111, 9999999999),
            'image_id' => $avatar->id,

        ]);

        return [
            'user_id' => $user->id,
            'business_name' => fake()->unique()->company,
            'merchant_unique_id' => fake()->unique()->randomNumber(6),
            'current_balance' => 0,
            'opening_balance' => 0,
            'vat' => 10,
            'cod_charges' => ['inside_city' => 15, 'sub_city' => 18, 'outside_city' => 20, 'liquid_fragile' => 22],
            'nid_id' => $nid->id,
            'trade_license' => $trade->id,
            'address' => fake()->address,
            'coverage_id' => rand(1, 3),
            'pickup_slot_id' => rand(1, 3),
        ];
    }
}
