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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained()->onDelete('cascade');
            $table->date('start_date');
            $table->date('expected_end_date');
            $table->date('actual_end_date')->nullable();
            $table->decimal('project_cost', 10, 2);
            $table->decimal('project_revenue', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
