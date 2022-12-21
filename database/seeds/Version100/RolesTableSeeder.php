<?php

use Illuminate\Database\Seeder;
use Database\TruncateTable;
use Database\DisableForeignKeys;

class RolesTableSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        $exists = \App\Models\Auth\Role::query()->count();

        if ($exists == 0) {
            /*Only create on the first seed*/
            $roles = (new \App\Repositories\Access\RoleRepository())->query()->firstOrCreate(['id' => '1'],[
                'name' => 'System Admin',
                'description' => 'Administrator',
                'isactive' => '1',
                'isadmin' => '1',
            ]);

            /*CUSTOM Finance manager*/
            $roles = (new \App\Repositories\Access\RoleRepository())->query()->firstOrCreate(['id' => '2'], [
                'name' => 'System Manager',
                'description' => 'Manage all modules',
                'isactive' => '1',
                'isadmin' => '0',
            ]);


            /*Accountant Officer*/
            $roles = (new \App\Repositories\Access\RoleRepository())->query()->firstOrCreate(['id' => '3'], [
                'name' => 'Inspector',
                'description' => 'Manage all tour Operators',
                'isactive' => '1',
                'isadmin' => '0',

            ]);

        }
    }
}
