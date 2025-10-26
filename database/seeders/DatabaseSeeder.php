<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create users
        $users = User::factory(50)->create();

        // Create products
        $products = Product::factory(30)->create();

        // Create orders with order items
        foreach ($users as $user) {
            // Each user gets 1-5 orders
            $orderCount = rand(1, 5);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::factory()->create([
                    'user_id' => $user->id,
                ]);

                // Each order has 1-4 items
                $itemCount = rand(1, 4);
                $totalAmount = 0;

                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 5);
                    $price = $product->price;

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    $totalAmount += ($price * $quantity);
                }

                // Update order total amount
                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}
