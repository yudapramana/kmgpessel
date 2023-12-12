<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Log;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $data = [
            ['name' => 'PRAMANA YUDA', 'username' => '199407292022031002', 'email' => '199407292022031002@kemenag.go.id', 'password' => Hash::make('1000kali'), 'plain_password' => '1000kali', 'current_role_id' => 1, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
            ['name' => 'RHAMA EKA PUTRA', 'username' => '198605082011011013', 'email' => '198605082011011013@kemenag.go.id', 'password' => Hash::make('rhama123'), 'plain_password' => 'rhama123', 'current_role_id' => 2, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],

            ['name' => 'ERI GUSNEDI', 'username' => '197807302007011009', 'email' => '197807302007011009@kemenag.go.id', 'password' => Hash::make('erigusnedi123'), 'plain_password' => 'erigusnedi123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
            ['name' => 'RISNA YANTI', 'username' => '198007022005012012', 'email' => '198007022005012012@kemenag.go.id', 'password' => Hash::make('risnayanti123'), 'plain_password' => 'risnayanti123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
            ['name' => 'VETHRIA RAHMI', 'username' => '198110082007012016', 'email' => '198110082007012016@kemenag.go.id', 'password' => Hash::make('vethiarahmi123'), 'plain_password' => 'vethiarahmi123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
            ['name' => 'FITRA DEWI', 'username' => '198512082005012001', 'email' => '198512082005012001@kemenag.go.id', 'password' => Hash::make('fitradewi123'), 'plain_password' => 'fitradewi123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
            ['name' => 'RIZKI RONALDI', 'username' => '198203092009011007', 'email' => '198203092009011007@kemenag.go.id', 'password' => Hash::make('rizkironaldi123'), 'plain_password' => 'rizkironaldi123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 0],
        
            ['name' => 'AFNIZON', 'username' => '197610182009011004', 'email' => '197610182009011004@kemenag.go.id', 'password' => Hash::make('afnizon123'), 'plain_password' => 'afnizon123', 'current_role_id' => 3, 'created_at' =>  \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now(), 'id_kabkota' => 1302],
        
        ];


        foreach ($data as $key => $item) {
            \App\Models\User::firstOrCreate(
                ['username' => $item['username']],
                $item
            );
        }

        
    }
}
