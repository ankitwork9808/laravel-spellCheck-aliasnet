<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('companyid')->unique();
            $table->text('name')->index();
            $table->string('token')->unique();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->text('address')->nullable();
            $table->text('city')->nullable();
            $table->foreignId('state_id')->nullable()->constrained();
            $table->foreignId('country_id')->nullable()->constrained();
            $table->text('postal_code')->nullable();
            $table->text('website')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->dateTime('last_active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
