<?php

use App\Containers\User\Domain\Enums\Sex\SexEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('verify_code')->nullable();
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->date('birth')->nullable();
            $table->integer('sex')->default(SexEnum::man()->label);
            $table->boolean('allow_ads')->default(false);
            $table->boolean('allow_privacy')->default(false);
            $table->boolean('allow_geocoding')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
