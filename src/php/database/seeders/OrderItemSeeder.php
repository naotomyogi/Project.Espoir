<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_items')->insert(
            [
                [
                    'id'             => '1',
                    'item_id'        => '3',
                    'order_id'       => '1',
                    'customed_price' => '550',
                    'quantity'       => '2'
                ],
                [
                    'id'             => '2',
                    'item_id'        => '1',
                    'order_id'       => '2',
                    'customed_price' => '200',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '3',
                    'item_id'        => '2',
                    'order_id'       => '2',
                    'customed_price' => '300',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '4',
                    'item_id'        => '1',
                    'order_id'       => '3',
                    'customed_price' => '200',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '5',
                    'item_id'        => '2',
                    'order_id'       => '3',
                    'customed_price' => '300',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '6',
                    'item_id'        => '2',
                    'order_id'       => '4',
                    'customed_price' => '300',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '7',
                    'item_id'        => '4',
                    'order_id'       => '4',
                    'customed_price' => '200',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '8',
                    'item_id'        => '2',
                    'order_id'       => '5',
                    'customed_price' => '300',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '9',
                    'item_id'        => '4',
                    'order_id'       => '5',
                    'customed_price' => '200',
                    'quantity'       => '1'
                ],
                [
                    'id'             => '10',
                    'item_id'        => '5',
                    'order_id'       => '5',
                    'customed_price' => '450',
                    'quantity'       => '1'
                ]
            ]
        );
    }
}
