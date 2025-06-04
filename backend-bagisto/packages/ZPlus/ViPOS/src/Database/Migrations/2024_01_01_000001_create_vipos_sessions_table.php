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
        Schema::create('vipos_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->decimal('opening_amount', 12, 4)->default(0);
            $table->decimal('closing_amount', 12, 4)->nullable();
            $table->decimal('expected_amount', 12, 4)->default(0);
            $table->decimal('total_sales', 12, 4)->default(0);
            $table->integer('total_orders')->default(0);
            $table->text('opening_notes')->nullable();
            $table->text('closing_notes')->nullable();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('admins')->onDelete('cascade');
            $table->index(['status', 'opened_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vipos_sessions');
    }
};