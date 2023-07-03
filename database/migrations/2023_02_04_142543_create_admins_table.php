<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->tinyInteger('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email_address')->unique();
            $table->string('telephone', 10)->nullable();
            $table->string('password')
                ->default('$2y$10$FoBBT6brPzjximfpWtC7LedZ4vu9hzFlN0xH6pYMn48iagXUdWSoy'); // Aa@123456
            $table->tinyInteger('role')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->boolean('first_login_flag')->default(0);
            $table->string('refresh_token')->nullable();
            $table->dateTime('refresh_token_expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}