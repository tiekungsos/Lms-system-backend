<?php

namespace Database\Seeders;

use App\Models\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => 1,
                'name'       => 'Lead',
                'created_at' => '2021-06-07 16:05:34',
                'updated_at' => '2021-06-07 16:05:34',
            ],
            [
                'id'         => 2,
                'name'       => 'Customer',
                'created_at' => '2021-06-07 16:05:34',
                'updated_at' => '2021-06-07 16:05:34',
            ],
            [
                'id'         => 3,
                'name'       => 'Partner',
                'created_at' => '2021-06-07 16:05:34',
                'updated_at' => '2021-06-07 16:05:34',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
