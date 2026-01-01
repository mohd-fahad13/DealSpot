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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            // $table->foreignId('location_ids')->constrained()->onDelete('cascade')->after('business_id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('discount_value', 8, 2);
            $table->enum('discount_type', ['percentage', 'amount']);
            $table->text('terms')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('min_purchase', 10, 2)->nullable();
            $table->string('promo_code')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('status', ['active', 'inactive', 'expired'])->default('active');
            // $table->bigInteger('view_count')->default(0);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
