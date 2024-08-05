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
        Schema::create('service_tour', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('tour_id');
            $table->enum('service_type', ['back', 'forth']);
            $table->enum('status', ['pending', 'active','rejected'])->default('pending');
            $table->json('service_contents_ids');
            $table->date('date_appointment');
            $table->timestamps();





            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_tour');
    }
};
