<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed the default permissions
        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            Permission::firstOrCreate(['name' => $perms]);
        }

        $this->command->info('Default Permissions added.');

        // Confirm roles needed
        if ($this->command->confirm('Create Roles for user, default is root, admin and user? [y|N]', true)) {

            // Ask for roles from input
            $input_roles = $this->command->ask('Enter roles in comma separate format.', 'root,admin,user');

            // Explode roles
            $roles_array = explode(',', $input_roles);

            // add roles
            foreach ($roles_array as $role) {
                $role = Role::create(['name' => trim($role)]);
                if ($role->name == Role::ROOT) {
                    // assign all permissions
                    $role->syncPermissions(Permission::all());
                    $this->command->info('Root granted all the permissions');
                } elseif ($role->name == Role::ADMIN) {
                    // for others by default only create, read and update access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'add_%')
                        ->orWhere('name', 'LIKE', 'edit_%')
                        ->orWhere('name', 'LIKE', 'view_%')
                        ->get());
                } else {
                    // for others by default only view access
                    $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
                }
                // create one user for each role
                $this->createUser($role);
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');
        } else {

            $defaultRoles = Role::defaultRoles();

            foreach ($defaultRoles as $role) {
                Role::firstOrCreate(['name' => $role]);
            }

            $this->command->info('Added only default role.');
        }

        $this->command->warn('All done :)');
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($role)
    {
        if ($role->name == Role::ROOT) {
            $user = User::create([
                'name' => 'Adi Arta Wibawa',
                'current_role_id' => $role->id,
                'email' => 'surat.buat.adi@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('fujiyama'),
                'remember_token' => Str::random(10),
            ]);
        } else {
            // assign root user has every role the application
            $root = User::whereEmail('surat.buat.adi@gmail.com')->first();
            $root->assignRole($role->id);

            $user = User::factory()->create(['current_role_id' => $role->id]);
        }

        $user->assignRole($role);

        if ($role->name == Role::ROOT) {
            $this->command->info('Here is your super user details to login:');
            $this->command->warn($user->email);
            $this->command->warn('Password is "loveofmylife"');
        }
    }
}
