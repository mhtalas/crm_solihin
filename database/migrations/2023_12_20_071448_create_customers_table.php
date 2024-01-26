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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('pic_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->integer('province_id');
            $table->integer('city_id');
            $table->text('address')->nullable();
            $table->foreignIdFor(\App\Models\LeadSource::class)->nullable()->constrained();
            $table->integer('employee_id');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('customer_tag', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Customer::class)->constrained();
            $table->foreignIdFor(\App\Models\Tag::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
