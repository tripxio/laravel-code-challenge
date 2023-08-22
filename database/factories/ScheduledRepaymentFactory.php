<?php

namespace Database\Factories;

use App\Models\ScheduledRepayment;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Loan;

class ScheduledRepaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ScheduledRepayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            // TODO: Complete factory
            'loan_id'=>Loan::factory()->create(),
            'amount'=>5000,
            'outstanding_amount'=>0,
            'currency_code'=>'12',
            'due_date'=>'2020-04-20',
            'status'=>ScheduledRepayment::STATUS_REPAID


        ];
    }
}
