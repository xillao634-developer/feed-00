<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference_code')->unique();
            $table->string('category');
            $table->string('subject');
            $table->text('message');
            $table->string('file_path')->nullable();
            $table->foreignId('assigned_department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->enum('status', ['pending', 'in_progress', 'resolved'])->default('pending');
            $table->boolean('anonymous')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
