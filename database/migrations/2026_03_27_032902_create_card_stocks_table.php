<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('card_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('number_transaction')->nullable();
            $table->enum('transaction_type', ['in', 'out', 'adjustment', 'return']);
            $table->integer('amount_in');
            $table->integer('amount_out');
            $table->integer('stock_after');
            $table->string('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_stocks');
    }
};
