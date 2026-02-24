<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('model');
            $table->string('brand');
            $table->year('manufacture_year');
            $table->year('acquisition_year');
            $table->string('serial_number')->unique();
            $table->string('image')->nullable();
            $table->enum('status', ['Disponível', 'Alugada', 'Em Manutenção'])->default('Disponível'); 
            $table->decimal('hourly_rate', 10, 2)->default(0.00);
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
