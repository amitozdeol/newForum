<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->unique();
            $table->string('education')->nullable();
            $table->string('sponsor')->nullable();
            $table->string('telegram')->unique();
            $table->boolean('is_admin')->default(0);
            $table->text('skills')->nullable();
            $table->boolean('is_deleted')->default(0);
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_banned')->default(0);
            $table->integer('rank')->default(0);         
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
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
