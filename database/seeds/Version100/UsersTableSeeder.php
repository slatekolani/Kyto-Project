<?php

use Database\DisableForeignKeys;
use Database\TruncateTable;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $exists = \App\Models\Auth\User::query()->count();

        if ($exists == 0) {
            /*Only create on the first seed*/

            $user = (new \App\Repositories\Access\UserRepository())->query()->firstOrCreate(['id' => '1'], [
                'username' => 'Edgar Fwalo',
                'email' => 'edgarfwalo99@gmail.com',
                'phone' => '0743154530',
                'password' => bcrypt('12345678'),
                'confirmation_code'=>'898989',
                'role'=>'1'
            ]);
            $user->roles()->sync([1]);

        }
    }
}

