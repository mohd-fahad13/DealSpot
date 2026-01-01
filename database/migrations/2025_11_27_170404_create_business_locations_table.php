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
        Schema::create('business_locations', function (Blueprint $table) {
            $table->id();

            // Link to business
            $table->foreignId('business_id')
                ->constrained('businesses')
                ->onDelete('cascade');

            $table->string('branch_name')->nullable();     // Example: "Sector 18 Branch"
            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();

            // Geo coordinates (optional)
            // $table->decimal('latitude', 10, 7)->nullable();
            // $table->decimal('longitude', 10, 7)->nullable();

            $table->boolean('is_primary')->default(false); // Main branch indicator

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_locations');
    }
};
