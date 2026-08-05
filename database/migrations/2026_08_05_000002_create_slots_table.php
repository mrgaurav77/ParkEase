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
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parking_lot_id')->constrained('parking_lots')->onDelete('cascade');
            $table->string('slot_number'); // e.g. A1, A2, B1
            $table->enum('slot_type', ['regular', 'ev', 'handicap', 'compact'])->default('regular');
            $table->string('floor')->default('Ground Floor');
            $table->integer('x_coord')->default(0); // For HTML5 Canvas map rendering
            $table->integer('y_coord')->default(0); // For HTML5 Canvas map rendering
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['parking_lot_id', 'slot_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slots');
    }
};
