<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED PRIMARY KEY

            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');

            // Foreign key to departments table
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained('departments')
                  ->nullOnDelete();

            $table->string('role')->default('user'); // admin | staff | user etc.

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
