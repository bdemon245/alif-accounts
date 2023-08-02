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

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('program_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->json('trailer_no');
            $table->bigInteger('chalan')->nullable()->default(0);
            $table->bigInteger('advance')->nullable()->default(0);
            $table->bigInteger('due')->nullable()->default(0);
            $table->bigInteger('rent')->nullable()->default(0);
            $table->bigInteger('commission')->nullable()->default(0);
            $table->boolean('chalan_collected')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
