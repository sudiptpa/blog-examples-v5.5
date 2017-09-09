<?php

use App\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(1, 20) as $key => $each) {
            Order::create([
                'transaction_id' => null,
                'amount' => 20 + $each,
                'payment_status' => 0,
            ]);
        }
    }
}
