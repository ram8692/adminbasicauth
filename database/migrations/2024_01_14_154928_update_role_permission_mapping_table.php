<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRolePermissionMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('role_permission_mapping', 'role_action_mapping');

        Schema::table('role_action_mapping', function (Blueprint $table) {
            $table->renameColumn('permission_id', 'action_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_action_mapping', function (Blueprint $table) {
            $table->renameColumn('action_id', 'permission_id');
        });

        Schema::rename('role_action_mapping', 'role_permission_mapping');
    }
}
