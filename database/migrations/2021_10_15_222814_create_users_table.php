<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned(true);

            $table->foreignId('role_id')
                ->constrained('roles')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->string('username', 100)->index('idx_user_username');
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->timestamps();

            $table->index(['email', 'password'], 'idx_user_auth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
