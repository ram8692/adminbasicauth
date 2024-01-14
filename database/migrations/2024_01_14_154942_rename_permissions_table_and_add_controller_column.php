<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePermissionsTableAndAddControllerColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('permissions', 'actions');

        Schema::table('actions', function (Blueprint $table) {
            $table->string('controller')->nullable()->after('name');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('actions', function (Blueprint $table) {
            $table->dropColumn('controller');
        });

        Schema::rename('actions', 'permissions');
    }
}
