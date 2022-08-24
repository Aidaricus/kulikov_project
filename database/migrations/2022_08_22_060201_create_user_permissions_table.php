<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_permission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('permission_id');

            $table->index('user_id', 'user_permission_user_idx');
            $table->index('permission_id', 'user_permission_permission_idx');

            $table->foreign('user_id', 'user_permission_user_fk')->on('users')->references('id');
            $table->foreign('permission_id', 'user_permission_permission_fk')->on('permissions')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_permission');
    }
};
