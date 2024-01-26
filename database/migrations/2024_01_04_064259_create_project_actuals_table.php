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
        Schema::create('project_actuals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Project::class)->constrained();
            $table->foreignIdFor(\App\Models\Product::class)->constrained();
            $table->unsignedInteger('quantity_quote')->default(0);
            $table->unsignedInteger('quantity_actual')->default(0);
            $table->double('price')->default(0);
            $table->double('actual_quote')->default(0);
            $table->double('actual_final')->default(0);
            $table->double('refund')->default(0);
            $table->double('additional')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_actuals');
    }
};
