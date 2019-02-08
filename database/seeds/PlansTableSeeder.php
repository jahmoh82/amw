<?php

use Illuminate\Database\Seeder;

class PlansTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('plans')->delete();
        
        \DB::table('plans')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pay as you play',
                'description' => 'Signup for the Pay as you play plan',
                'features' => 'Pay when you play',
                'plan_id' => 'basic',
                'role_id' => 3,
                'default' => 0,
                'price' => 0,
                'trial_days' => 0,
                'created_at' => '2018-07-03 05:03:56',
                'updated_at' => '2018-07-03 17:17:24',
            )
        ));
        
        
    }
}