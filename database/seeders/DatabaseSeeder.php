<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
        ]);
        
        Role::insert([
            [
            'name' => 'super-admin',
            'guard_name' => 'web',
            ],
            [
                'name' => 'Franchise-Admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'Student-Admin',
                'guard_name' => 'web',
            ],
        ]);
        // DB::table("permissions")->insert([
            
        // ]);
        User::create(
            [
                'name' => 'Super Admin',
                'email' => 'actiindia2022@gmail.com',
                'email_verified_at' => Carbon::now()->toDateTimeString(),
                'password' => Hash::make('acti@12#52022'), 
            ],
        );
        $role = Role::find(1);
        $franchise = Role::where('name','Franchise-Admin')->first();
        $student = Role::where('name', 'Student-Admin')->first();
        $user = User::find(1);

        $permissions = Permission::pluck('id', 'id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);

        $franchise->givePermissionTo(['student_list','student_add','student_edit','student_delete','student_show','student-course-list','student-course-add','student-course-edit','student-course-delete']);
        $franchise->givePermissionTo('course_list');
    }
}
