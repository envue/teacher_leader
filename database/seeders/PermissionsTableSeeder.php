<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'time_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'time_work_type_create',
            ],
            [
                'id'    => 19,
                'title' => 'time_work_type_edit',
            ],
            [
                'id'    => 20,
                'title' => 'time_work_type_show',
            ],
            [
                'id'    => 21,
                'title' => 'time_work_type_delete',
            ],
            [
                'id'    => 22,
                'title' => 'time_work_type_access',
            ],
            [
                'id'    => 23,
                'title' => 'time_project_create',
            ],
            [
                'id'    => 24,
                'title' => 'time_project_edit',
            ],
            [
                'id'    => 25,
                'title' => 'time_project_show',
            ],
            [
                'id'    => 26,
                'title' => 'time_project_delete',
            ],
            [
                'id'    => 27,
                'title' => 'time_project_access',
            ],
            [
                'id'    => 28,
                'title' => 'time_entry_create',
            ],
            [
                'id'    => 29,
                'title' => 'time_entry_edit',
            ],
            [
                'id'    => 30,
                'title' => 'time_entry_show',
            ],
            [
                'id'    => 31,
                'title' => 'time_entry_delete',
            ],
            [
                'id'    => 32,
                'title' => 'time_entry_access',
            ],
            [
                'id'    => 33,
                'title' => 'time_report_create',
            ],
            [
                'id'    => 34,
                'title' => 'time_report_edit',
            ],
            [
                'id'    => 35,
                'title' => 'time_report_show',
            ],
            [
                'id'    => 36,
                'title' => 'time_report_delete',
            ],
            [
                'id'    => 37,
                'title' => 'time_report_access',
            ],
            [
                'id'    => 38,
                'title' => 'time_population_type_create',
            ],
            [
                'id'    => 39,
                'title' => 'time_population_type_edit',
            ],
            [
                'id'    => 40,
                'title' => 'time_population_type_show',
            ],
            [
                'id'    => 41,
                'title' => 'time_population_type_delete',
            ],
            [
                'id'    => 42,
                'title' => 'time_population_type_access',
            ],
            [
                'id'    => 43,
                'title' => 'time_caseload_type_create',
            ],
            [
                'id'    => 44,
                'title' => 'time_caseload_type_edit',
            ],
            [
                'id'    => 45,
                'title' => 'time_caseload_type_show',
            ],
            [
                'id'    => 46,
                'title' => 'time_caseload_type_delete',
            ],
            [
                'id'    => 47,
                'title' => 'time_caseload_type_access',
            ],
            [
                'id'    => 48,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
