<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;

use Spatie\Permission\Models\Permission;

use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        // create permissions
        Permission::create(['name' => 'index.personal']);
        Permission::create(['name' => 'index.contratos']);
        Permission::create(['name' => 'index.planilla']);
        Permission::create(['name' => 'index.afp']);
        Permission::create(['name' => 'index.reportes']);
        Permission::create(['name' => 'index.herramientas']);
        Permission::create(['name' => 'index.configuracion']);   

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'Tecnico']);
        $role1->givePermissionTo('index.personal');
        $role1->givePermissionTo('index.contratos');
        $role1->givePermissionTo('index.planilla');
        $role1->givePermissionTo('index.reportes');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('index.personal');
        $role2->givePermissionTo('index.contratos');
        $role2->givePermissionTo('index.planilla');
        $role2->givePermissionTo('index.reportes');
        $role2->givePermissionTo('index.herramientas');
        $role2->givePermissionTo('index.configuracion');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider
    }
}
