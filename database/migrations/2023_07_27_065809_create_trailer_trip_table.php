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

        Schema::create('trailer_trip', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trip_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('trailer_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->bigInteger('chalan')->nullable();
            $table->bigInteger('rent')->nullable();
            $table->bigInteger('advance')->nullable();
            $table->bigInteger('due')->nullable();
            $table->bigInteger('commission')->nullable();
            $table->boolean('chalan_returned')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trailer_trip');
    }
};
