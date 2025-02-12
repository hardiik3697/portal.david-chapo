<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(){
        $data = [
            [
                'name' => 'Fruits',
                'description' => 'Apples, bananas,  grapes, oranges, strawberries, avocados, peaches, etc.'
            ],
            [
                'name' => 'Vegetables',
                'description' => 'Potatoes, onions, carrots, salad greens, broccoli, peppers, tomatoes, cucumbers, etc.'
            ],
            [
                'name' => 'Dairy',
                'description' => 'Butter, cheese, eggs, milk, yogurt, etc.'
            ],
            [
                'name' => 'Snacks',
                'description' => 'Chips, pretzels, popcorn, crackers, nuts, etc.'
            ],
            [
                'name' => 'Beverages',
                'description' => 'Coffee, teabags, milk, juice, soda, beer, wine, etc.'
            ],
            [
                'name' => 'Frozen Foods',
                'description' => 'Pizza, fish, potatoes, ready meals, ice cream, etc.'
            ],
        ];
        
        foreach($data as $row){
            $id = Category::insertGetId([
                'name' => $row['name'],
                'description' => $row['description'],
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => 1
            ]);  
        }
    }
}
