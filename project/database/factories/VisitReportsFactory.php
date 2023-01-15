<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\VisitReports;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class VisitReportsFactory extends Factory
{
    protected $model = VisitReports::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'appointment_date'  => NULL,	
            'report_text' => NULL,	
            'user_id' => NULL,
            'customer_id' => NULL
        ];
    }
}
