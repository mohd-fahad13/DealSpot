<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('business_owners')->onDelete('cascade');
            $table->string('business_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            // $table->text('address')->nullable();
            // $table->string('country');
            // $table->string('state');
            // $table->string('city');
            // $table->string('postal_code')->nullable();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
