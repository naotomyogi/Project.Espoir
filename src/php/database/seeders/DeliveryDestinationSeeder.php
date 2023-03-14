<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryDestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('delivery_destinations')->insert(
            [
                [
                    'id'                        => '1',
                    'user_id'                   => '1',
                    'delivery_destination_name' => '自宅',
                    'zipcode'                   => '1111111',
                    'address'                   => '東京都新宿区新宿1-1-1',
                    'telephone'                 => '09011111111'
                ],
                [
                    'id'                        => '2',
                    'user_id'                   => '1',
                    'delivery_destination_name' => '会社',
                    'zipcode'                   => '2222222',
                    'address'                   => '東京都新宿区新宿2-2-2',
                    'telephone'                 => '09022222222'
                ],
                [
                    'id'                        => '3',
                    'user_id'                   => '1',
                    'delivery_destination_name' => '実家',
                    'zipcode'                   => '3333333',
                    'address'                   => '東京都新宿区新宿3-3-3',
                    'telephone'                 => '09033333333'
                ]
            ]
        );
    }
}