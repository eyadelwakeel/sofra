<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {

            // ❌ حذف عمود rating
            $table->dropColumn('rating');

            // ✅ إضافة الأعمدة الجديدة
            $table->decimal('minimum_order', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {

            // رجوع التعديلات
            $table->decimal('rating', 2, 1)->nullable();

            $table->dropColumn(['minimum_order', 'delivery_fee']);
        });
    }
};