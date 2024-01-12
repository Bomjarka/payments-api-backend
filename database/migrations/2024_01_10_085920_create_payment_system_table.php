<?php

use App\Models\PaymentSystem;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_system', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->string('name')->unique();
            $table->timestamps();
        });

        foreach (PaymentSystem::PAYMENT_SYSTEMS as $merchantName => $merchantId) {
            PaymentSystem::create([
                'id' => $merchantId,
                'name' => $merchantName,
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_system');
    }
};
