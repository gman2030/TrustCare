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
        Schema::table('messages', function (Blueprint $table) {
            // إضافة عمود نصي لتخزين مسار صورة الضمان، ويكون بعد عمود المحتوى (content)
            $table->string('warranty_image')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // حذف العمود في حال قررت التراجع عن الميجريشن
            $table->dropColumn('warranty_image');
        });
    }
};
