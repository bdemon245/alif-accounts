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
            $table->foreignId('party_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('factory_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('delivery_date');
            $table->boolean('is_cash')->default(false);
            $table->bigInteger('chalan_total')->nullable();
            $table->bigInteger('rent_total')->nullable();
            $table->bigInteger('advance_total')->nullable();
            $table->bigInteger('due_total')->nullable();
            $table->bigInteger('commission_total')->nullable();
            $table->boolean('chalan_collected')->default(false);
            $table->boolean('status')->default(true);
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
