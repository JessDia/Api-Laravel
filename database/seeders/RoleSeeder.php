<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* admin = todos los CRUD
        * vendedor = CRUD de productos
        * cliente = listar productos y editar 
        
        */ 
    
        $admin = Role::create(['name' => 'admin']);
        $vendedor = Role::create(['name' => 'vendedor']);
        $cliente = Role::create(['name' => 'cliente']);

        //Permisos del CRUD de productos
        Permission::create(['name' => 'listar.productos'])->syncRoles($admin, $vendedor, $cliente);
        // Permission::create(['name' => 'editar. producto'])->syncRoles($admin, $cliente); //funcion pendiente por crear 
        Permission::create(['name' => 'crear.productos'])->syncRoles($admin, $vendedor);
        Permission::create(['name' => 'obtener.producto'])->syncRoles($admin, $vendedor);
        Permission::create(['name' => 'actualizar.producto'])->syncRoles($admin, $vendedor, $cliente);
        Permission::create(['name' => 'eliminar.producto'])->syncRoles($admin, $vendedor);

        //Permisos del CRUD de usuarios
        Permission::create(['name' => 'ver.usuarios'])->syncRoles($admin);
        // Permission::create(['name' => 'editar.usuarios'])->syncRoles($admin); //funcion pendiente de crear
        Permission::create(['name' => 'crear.usuarios'])->syncRoles($admin);
        Permission::create(['name' => 'obtener.usuarios'])->syncRoles($admin);
        Permission::create(['name' => 'actualizar.usuarios'])->syncRoles($admin);
        Permission::create(['name' => 'eliminar.usuarios'])->syncRoles($admin);



    }
}
