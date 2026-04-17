<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistProfilesTable extends Migration
{
    public function up()
    {
        Schema::create('specialist_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('city');
            $table->text('description')->nullable();
            $table->boolean('with_guarantee')->default(false);
            $table->boolean('works_by_contract')->default(false);
            $table->boolean('passport_verified')->default(false);
            $table->boolean('is_organization')->default(false);
            $table->timestamp('last_online_at')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialist_profiles');
    }
}
