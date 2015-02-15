<?php 

use Illuminate\Database\Seeder;

use MWO\Role;
use MWO\User;
use MWO\Permission;

class UserSystemSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // wipe the tables
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::table('permissions')->delete();

        // Add the Roles
        // 
        $ownerRole = Role::create(array(
            'name' => 'owner',
            'display_name' => 'Owner',
            'description' => 'Owns the application, and has access to all production features.',
        ));

        $authorRole = Role::create(array(
            'name' => 'author',
            'display_name' => 'Author',
            'description' => 'Can write new blog posts.',
        ));

        $userRole = Role::create(array(
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Can comment and receive site updates.',
        ));

        // Add the permissions
        // 
        $useDashboard = Permission::create(array(
            'name' => 'dashboard.use',
            'display_name' => 'Use Dashboard',
            'description' => 'Allows basic access to the administration dashboard.',
        ));

        // Attach the permissions to Roles
        // 
        $ownerRole->attachPermissions([
            $useDashboard,
        ]);
        $authorRole->attachPermissions([
            $useDashboard,
        ]);

        // Add initial user(s)
        // 
        $user = User::create(
            array(
                'name' => 'Greg',
                'email' => 'contact@gbrock.com',
                'password' => bcrypt('password'),
            )
        );

        // Attach roles to user
        $user->attachRoles([
            $userRole,
            $authorRole,
            $ownerRole,
        ]);
    }

}
