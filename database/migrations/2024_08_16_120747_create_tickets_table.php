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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('place');
            $table->time('time');
            $table->decimal('price', 8, 2);
            $table->foreignId('organizer_id')->constrained()->onDelete('cascade');
            $table->integer('spots');
            $table->string('status')->default('available');
            $table->timestamps();

            $table->unique(['organizer_id', 'time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
