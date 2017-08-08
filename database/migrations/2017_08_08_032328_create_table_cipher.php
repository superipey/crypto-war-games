<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCipher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ciphers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_team');
            $table->string('plain_text');
            $table->integer('shift_number');
            $table->string('cipher_text_1');
            $table->string('cipher_text_2');
            $table->string('key');
            $table->text('salt_8');
            $table->text('salt_16');
            $table->text('salt_24');
            $table->text('salt_32');
            $table->text('salt_any');
            $table->string('real_salt');
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
        Schema::dropIfExists('cipher');
    }
}
