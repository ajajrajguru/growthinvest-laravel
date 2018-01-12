<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AlterPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->string('display_name');
            $table->string('type');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->string('display_name');
            $table->string('type');
        });

        $roles = Role::get(); //Get all roles

        foreach ($roles as $key => $role) { 
            $roleName = $role->name;
            $type = $role->guard_name;

            $role->name = str_slug($roleName);
            $role->display_name = $roleName;
            $role->type = $type;
            $role->guard_name = 'web';
            $role->save();

        }

        $permissions = Permission::get(); //Get all roles

        foreach ($permissions as $key => $permission) {
            $permissionName = $permission->name;
            $type = $permission->guard_name;

            $permission->name = str_slug($permissionName);
            $permission->display_name = $permissionName;
            $permission->type = $type;
            $permission->guard_name = 'web';
            $permission->save();

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
