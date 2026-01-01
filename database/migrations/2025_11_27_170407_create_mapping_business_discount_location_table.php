<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mapping_business_discount_location', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('business_id');
            $table->unsignedBigInteger('discount_id');
            $table->unsignedBigInteger('location_id');

            $table->timestamps();

            // Indexes
            $table->index('business_id');
            $table->index('discount_id');
            $table->index('location_id');

            // If you are using foreign keys in other migrations and names match:
            $table->foreign('business_id')
                ->references('id')->on('businesses')
                ->onDelete('cascade');

            $table->foreign('discount_id')
                ->references('id')->on('discounts')
                ->onDelete('cascade');

            $table->foreign('location_id')
                ->references('id')->on('business_locations')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mapping_business_discount_location');
    }
};
