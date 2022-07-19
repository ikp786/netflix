<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
  
class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [ 
           'role-list',
           'role-create',
           'role-edit',
           'role-delete', 
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',            
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'permission-list',
           'permission-create',
           'permission-edit',
           'permission-delete',
           'property-list',
           'property-create',
           'property-edit',
           'property-delete',
           'city-list',
           'city-create',
           'city-edit',
           'city-delete',
           'feature-list',
           'feature-create',
           'feature-edit',
           'feature-delete',
           'special_price-list',
           'special_price-create',
           'special_price-edit',
           'special_price-delete',
           'booking-list',
           'booking-create',
           'booking-edit',
           'booking-delete',
           'contact_us-list',
           'contact_us-create' 
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}