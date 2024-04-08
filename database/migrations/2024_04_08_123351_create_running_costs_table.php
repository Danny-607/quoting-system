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
        Schema::create('running_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('catagory_id');
            $table->foreign('catagory_id')
            ->references('id')->on('catagories')
            ->onDelete('cascade');
            $table->string('name');
            $table->decimal('cost');
            $table->string('type');
            $table->date('date_incurred');
            $table->boolean('repeating')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('running_costs');
    }
};
