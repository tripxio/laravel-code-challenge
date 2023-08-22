<?php

namespace Database\Factories;

use App\Models\Loan;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;


class LoanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
        // TODO: Complete factory
        'user_id'=>User::factory()->create(),
        'amount'=>5000,
        'terms'=>3,
        'outstanding_amount'=>5000-1666,
        'currency_code'=>Loan::CURRENCY_VND,
        'processed_at'=>'2020-01-20',
        'status'=>Loan::STATUS_DUE,

        ];





    }








}
