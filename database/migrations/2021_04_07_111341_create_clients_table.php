<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->string('city', 100);
            $table->string('state', 100);
            $table->string('country', 100);
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->string('phone_1', 20);
            $table->string('phone_2', 20)->nullable();
            $table->string('zip', 20);
            $table->date('start_validity')->nullable();
            $table->date('end_validity')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
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
        Schema::dropIfExists('clients');
    }
}
