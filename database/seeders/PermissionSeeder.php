<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allProducts = [
            ['name' => 'role-create', 'guard_name' => 'web'],
['name' => 'role-edit', 'guard_name' => 'web'],
['name' => 'role-show', 'guard_name' => 'web'],
['name' => 'role-delete', 'guard_name' => 'web'],
['name' => 'permission-create', 'guard_name' => 'web'],
['name' => 'permission-delete', 'guard_name' => 'web'],
['name' => 'permission-edit', 'guard_name' => 'web'],
['name' => 'role-list', 'guard_name' => 'web'],
['name' => 'permission-list', 'guard_name' => 'web'],
['name' => 'user-list','guard_name' => 'web'],
['name' => 'user-create', 'guard_name' => 'web'],
['name' => 'user-edit', 'guard_name' => 'web'],
['name' => 'user-show', 'guard_name' => 'web'],
['name' => 'user-delete', 'guard_name' => 'web'],
['name' => 'student-list', 'guard_name' => 'web'],
['name' => 'review-show', 'guard_name' => 'web'],
['name' => 'notification-add', 'guard_name' => 'web'],
['name' => 'notification-delete', 'guard_name' => 'web'],
['name' => 'notification-read', 'guard_name' => 'web'],
['name' => 'notification-show', 'guard_name' => 'web'],
['name' => 'notification-list', 'guard_name' => 'web'],
['name' => 'student-add', 'guard_name' => 'web'],
['name' => 'student-edit', 'guard_name' => 'web'],
['name' => 'student-show', 'guard_name' => 'web'],
['name' => 'student-delete', 'guard_name' => 'web'],
['name' => 'customer-add', 'guard_name' => 'web'],
['name' => 'customer-list', 'guard_name' => 'web'],
['name' => 'customer-edit', 'guard_name' => 'web'],
['name' => 'customer-show', 'guard_name' => 'web'],
['name' => 'customer-delete', 'guard_name' => 'web'],
['name' => 'course-add', 'guard_name' => 'web'],
['name' => 'course-edit', 'guard_name' => 'web'],
['name' => 'course-list', 'guard_name' => 'web'],
['name' => 'course-delete', 'guard_name' => 'web'],
['name' => 'course-show', 'guard_name' => 'web'],
['name' => 'franchise-add', 'guard_name' => 'web'],
['name' => 'franchise-edit', 'guard_name' => 'web'],
['name' => 'franchise-list', 'guard_name' => 'web'],
['name' => 'franchise-show', 'guard_name' => 'web'],
['name' => 'franchise-delete', 'guard_name' => 'web'],
['name' => 'customer-franchise-add', 'guard_name' => 'web'],
['name' => 'customer-franchise-edit', 'guard_name' => 'web'],
['name' => 'customer-franchise-list', 'guard_name' => 'web'],
['name' => 'customer-franchise-show', 'guard_name' => 'web'],
['name' => 'customer-franchise-delete', 'guard_name' => 'web'],
['name' => 'student-course-list', 'guard_name' => 'web'],
['name' => 'student-course-add', 'guard_name' => 'web'],
['name' => 'student-course-edit', 'guard_name' => 'web'],
['name' => 'student-course-delete', 'guard_name' => 'web'],
['name' => 'customer-payment-list', 'guard_name' => 'web'],
['name' => 'customer-payment-add', 'guard_name' => 'web'],
['name' => 'customer-payment-edit', 'guard_name' => 'web'],
['name' => 'customer-payment-delete', 'guard_name' => 'web'],
['name' => 'ebook-list', 'guard_name' => 'web'],
['name' => 'ebook-add', 'guard_name' => 'web'],
['name' => 'ebook-edit', 'guard_name' => 'web'],
['name' => 'ebook-delete', 'guard_name' => 'web'],
['name' => 'syllabus-show', 'guard_name' => 'web'],
['name' => 'syllabus-add', 'guard_name' => 'web'],
['name' => 'syllabus-edit', 'guard_name' => 'web'],

        ];
    DB::table("permissions")->insert($allProducts);
        

    }
}
