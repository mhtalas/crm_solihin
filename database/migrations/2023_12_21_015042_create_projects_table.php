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
            $table->foreignIdFor(\App\Models\Customer::class)->constrained();
            $table->string('project_name');
            $table->foreignIdFor(\App\Models\User::class, 'employee_id')->nullable()->constrained('users');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->foreignIdFor(\App\Models\PipelineStage::class)->nullable()->constrained();
            $table->boolean('is_close')->default(false);
            $table->boolean('is_complete')->default(false);
            $table->text('note')->nullable();
            $table->double('deal_amount')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_user', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Project::class)->constrained();
            $table->foreignIdFor(\App\Models\User::class)->constrained();
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
