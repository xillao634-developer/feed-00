<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        foreach (['ICT','Finance','Academics','HR','Facilities'] as $name) {
            Department::create(['name' => $name]);
        }
    }
}
