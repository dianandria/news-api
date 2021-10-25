<?php

use Illuminate\Database\Seeder;
use App\Models\NewsCategory;
use Carbon\Carbon;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NewsCategory::insert([
         	[
         		'news_category_name' => 'Internasional',
         		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         		'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         	],
         	[
         		'news_category_name' => 'Nasional',
         		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         		'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         	],
         	[
         		'news_category_name' => 'Daerah',
         		'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
         		'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
         	],
        ]);
    }
}
