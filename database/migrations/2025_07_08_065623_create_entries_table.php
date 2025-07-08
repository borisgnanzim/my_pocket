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
        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 12, 2);
            $table->string('description')->nullable();
            $table->date('date');
            $table->enum('origin',['salary', 'investment', 'gift', 'other'])->nullable();
            $table->enum('category', ['food', 'transport', 'entertainment', 'bills', 'health', 'clothing', 'education', 'other'])->nullable();
            $table->string('currency', 3)->nullable(); // Default currency set
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entries');
    }
};
