<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'admin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin@123'),
            'role_id' => '1',
            'is_verify' => '1',
            'email_verified_at'=> now(),
        ]);
    
        $role = Role::create(['name' => 'admin']);
        
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
        

        $user_roles = [ 
           'customer',
           'vendor', 
        ];
     
        foreach ($user_roles as $us_data) {
             Role::create(['name' => $us_data]);
        }
 
    }
}