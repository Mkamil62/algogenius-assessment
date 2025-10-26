<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productsByCategory = [
            'Electronics' => [
                'iPhone 17 Pro Max',
                'Samsung Galaxy S25 Ultra',
                'Samsung Neo QLED 8K TV',
                'Dell XPS 15 Laptop',
                'Sony WH-1000XM5 Headphones',
                'Canon EOS R5',
                'Apple Watch Ultra 2',
                'Sony PlayStation 5 Pro',
                'Xbox Series X Console',
                'DJI Mavic 3 Pro',
            ],
            'Clothing' => [
                'Sana Safinaz Muzlin Lawns',
                'Khaadi Pret Kurta',
                'J. Stitched Suit',
                'Maria B Luxury Pret',
                'Bridal Couture By Asim Jofa',
                'Nishat Linen Khaddar Shirt',
                'Bonanza Satrangi Waistcoat',
                'Sapphire Tunic',
                'Unstitch Fabric by Alkaram Studio',
                'Baroque Lawn Pret',
            ],
            'Books' => [
                'Atomic Habits by James Clear',
                'The Midnight Library',
                'Project Hail Mary',
                'Thinking, Fast and Slow',
                'Sapiens: A Brief History',
                'The Psychology of Money',
                'Can\'t Hurt Me by David Goggins',
                'The 7 Habits of Highly Effective People',
                'Educated: A Memoir',
                'Becoming by Michelle Obama',
                'The Subtle Art of Not Giving a F*ck',
                'Rich Dad Poor Dad',
                'The Lean Startup',
                'Zero to One by Peter Thiel',
                'Good to Great by Jim Collins',
            ],
            'Home & Garden' => [
                'Dyson V15 Vacuum Cleaner',
                'Ninja Air Fryer Max XL',
                'KitchenAid Stand Mixer',
                'Instant Pot Duo Plus',
                'Keurig K-Elite Coffee Maker',
                'Shark Robot Vacuum',
                'Philips Hue Smart Bulbs',
                'Nest Learning Thermostat',
                'Cuisinart Food Processor',
                'OXO Good Grips Knife Set',
                'Lodge Cast Iron Skillet',
                'Pyrex Glass Storage Set',
                'Weber Spirit Gas Grill',
                'BLACK+DECKER Drill Set',
                'Fiskars Garden Tool Set',
            ],
            'Sports' => [
                'Peloton Bike+',
                'Bowflex Adjustable Dumbbells',
                'Fitbit Charge 6',
                'Garmin Forerunner 265 Watch',
                'TRX Suspension Training System',
                'Manduka PRO Yoga Mat',
                'Wilson Evolution Basketball',
                'Spalding NBA Street Basketball',
                'Callaway Golf Club Set',
                'TaylorMade Driver',
                'Yeti Rambler Water Bottle',
                'Hydro Flask Insulated Bottle',
                'Coleman Camping Tent 6-Person',
                'The North Face Backpack',
                'Schwinn Mountain Bike',
            ],
            'Toys' => [
                'LEGO Star Wars Millennium Falcon',
                'Hot Wheels Track Builder Set',
                'Barbie Dream House',
                'Nintendo Switch Mario Kart',
                'Nerf Elite 2.0 Blaster',
                'Play-Doh Modeling Compound Set',
                'Melissa & Doug Wooden Blocks',
                'Fisher-Price Little People Set',
                'Monopoly Board Game',
                'UNO Card Game',
                'Jenga Classic Game',
                'Crayola Ultimate Crayon Collection',
                'LEGO Classic Creative Bricks',
                'Baby Yoda Plush Toy',
                'PAW Patrol Action Figures',
            ],
        ];

        // Select a random category
        $category = fake()->randomElement(array_keys($productsByCategory));
        
        // Select a random product from that category
        $productName = fake()->randomElement($productsByCategory[$category]);
        
        // Set price ranges based on category
        $priceRanges = [
            'Electronics' => [199, 2999],
            'Clothing' => [29, 299],
            'Books' => [9.99, 39.99],
            'Home & Garden' => [24.99, 599],
            'Sports' => [19.99, 499],
            'Toys' => [9.99, 299],
        ];
        
        [$minPrice, $maxPrice] = $priceRanges[$category];
        
        return [
            'name' => $productName,
            'category' => $category,
            'price' => fake()->randomFloat(2, $minPrice, $maxPrice),
            'created_at' => fake()->dateTimeBetween('-90 days', 'now'),
        ];
    }
}
