<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vipos_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();

            $table->index('key');
        });

        // Insert default settings
        DB::table('vipos_settings')->insert([
            [
                'key' => 'receipt.store_name',
                'value' => 'My Store',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'receipt.store_address',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'receipt.store_phone',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'receipt.thank_you_message',
                'value' => 'Thank you for your purchase!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'tax.default_rate',
                'value' => '0',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'payment_methods.enabled',
                'value' => json_encode(['cash', 'card', 'upi', 'bank_transfer']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'display.products_per_page',
                'value' => '20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'display.theme_color',
                'value' => '#3B82F6',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vipos_settings');
    }
};