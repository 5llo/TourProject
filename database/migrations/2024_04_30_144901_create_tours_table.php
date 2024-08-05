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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('designer_id')->constrained()->onDelete('cascade');
            $table->json('path');
            $table->integer('quantity');
            $table->integer('tour_counter')->default(0);
            $table->date('date_start');
            $table->date('date_end');
            $table->text('description')->nullable();
            $table->enum('status', ['active','terminated','pending','rejected']);
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
