<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecialistServicesTable extends Migration
{
    public function up()
    {
        Schema::create('specialist_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialist_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->unsignedInteger('price_from')->nullable();
            $table->string('price_type')->default('by_agreement');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('specialist_services');
    }
}
