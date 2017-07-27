<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }
        $permissions = Permission::defaultPermissions();
        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms[0], 'cname' => $perms[1], 'group' => $perms[2]]);
        }
        $this->command->info('Default Permissions added.');
        if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Admin,User');
            $roles_array = explode(',', $input_roles);
            foreach ($roles_array as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);
                if ($role->name == 'Admin') {
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }
                $this->createUser($role);
            }
            $this->command->info('Roles ' . $input_roles . ' added successfully');
        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('Added only default user role.');
        }
        $this->command->info('Added passport client id and password');
        $this->command->call('passport:install',['--force']);


    }

    private function createUser($role)
    {
        $user = factory(App\User::class)->create(
            ['name'=>'hupo','password'=>bcrypt('4988yuji'),'email'=>'317559272@qq.com']
        );
        $user->assignRole($role->name);
        if ($role->name == 'Admin') {
            $this->command->info('Here is your admin details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "4988yuji"');
        }
    }

}
