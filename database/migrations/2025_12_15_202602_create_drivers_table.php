<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // ارتباط یک به یک با User
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();

            // وضعیت راننده (فعال / غیرفعال)
            $table->boolean('is_active')->default(true);

            // تاریخ شروع همکاری
            $table->date('started_at')->nullable();

            // آینده: می‌توان فیلدهای دیگر اضافه کرد مثل شماره پلاک یا مسیر
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
