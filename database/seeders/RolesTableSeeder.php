<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_administrator = Role::create(['name' => 'super_administrator']);
        $administrator = Role::create(['name' => 'administrator']);
        $staff = Role::create(['name' => 'kontributor_utama']);
        $staff = Role::create(['name' => 'kontributor_daerah']);


        // Super Admin
        $user = User::where('username', '199407292022031002')->first();
        $user->assignRole('super_administrator');

        // Administrator
        $user = User::where('username', '198605082011011013')->first();
        $user->assignRole('administrator');

        // Staff Administrator
        $user = User::where('username', '197807302007011009')->first();
        $user->assignRole('kontributor_utama');
        
        $user = User::where('username', '198007022005012012')->first();
        $user->assignRole('kontributor_utama');
        
        $user = User::where('username', '198110082007012016')->first();
        $user->assignRole('kontributor_utama');
        
        $user = User::where('username', '198512082005012001')->first();
        $user->assignRole('kontributor_utama');
        
        $user = User::where('username', '198203092009011007')->first();
        $user->assignRole('kontributor_utama');

        $user = User::where('username', '197610182009011004')->first();
        $user->assignRole('kontributor_daerah');
        

        // Permissions
        $permissionMenu1 = Permission::create(['name' => 'menu-dashboard']);
        $permissionMenu2 = Permission::create(['name' => 'menu-reservations']);
        $permissionMenu3 = Permission::create(['name' => 'menu-information']);
        $permissionMenu4 = Permission::create(['name' => 'menu-data']);
        $permissionMenu5 = Permission::create(['name' => 'menu-blog']);

        $permissionPage1_1 = Permission::create(['name' => 'page-dashboard']);

        $permissionPage2_1 = Permission::create(['name' => 'page-reservation-index']);
        $permissionPage2_2 = Permission::create(['name' => 'page-reservation-audits']);
        $permissionPage2_3 = Permission::create(['name' => 'page-reservation-deleted']);

        $permissionPage3_1 = Permission::create(['name' => 'page-information-services']);
        $permissionPage3_2 = Permission::create(['name' => 'page-information-products']);
        $permissionPage3_3 = Permission::create(['name' => 'page-information-galleries']);
        $permissionPage3_4 = Permission::create(['name' => 'page-information-carousels']);

        $permissionPage4_1 = Permission::create(['name' => 'page-data-messages']);
        $permissionPage4_2 = Permission::create(['name' => 'page-data-users']);
        $permissionPage4_3 = Permission::create(['name' => 'page-data-roles']);

        $permissionPage5_1 = Permission::create(['name' => 'page-blog-categories']);
        $permissionPage5_2 = Permission::create(['name' => 'page-blog-tags']);
        $permissionPage5_3 = Permission::create(['name' => 'page-blog-posts']);


        $super_administrator->givePermissionTo([
            $permissionMenu1, $permissionMenu2, $permissionMenu3, $permissionMenu4, $permissionMenu5,
            $permissionPage1_1,
            $permissionPage2_1, $permissionPage2_2, $permissionPage2_3,
            $permissionPage3_1, $permissionPage3_2, $permissionPage3_3, $permissionPage3_4,
            $permissionPage4_1, $permissionPage4_2, $permissionPage4_3,
            $permissionPage5_1, $permissionPage5_2, $permissionPage5_3
        ]);

        $administrator->givePermissionTo([
            $permissionMenu1, $permissionMenu2, $permissionMenu3, $permissionMenu4, $permissionMenu5,
            $permissionPage1_1,
            $permissionPage2_1, $permissionPage2_3,
            $permissionPage3_1, $permissionPage3_2, $permissionPage3_3, $permissionPage3_4,
            $permissionPage4_1, $permissionPage4_2,
            $permissionPage5_3
        ]);

        $staff->givePermissionTo([
            $permissionMenu1, $permissionMenu2, $permissionMenu3, $permissionMenu4, $permissionMenu5,
            $permissionPage1_1,
            $permissionPage2_1, $permissionPage2_3,
            $permissionPage3_1, $permissionPage3_2, $permissionPage3_3, $permissionPage3_4,
            $permissionPage4_1,
            $permissionPage5_3
        ]);
    }
}
