<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCipher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ciphers', function (Blueprint $table) {
            $table->renameColumn('cipher_text_1', 'cipher_text');
            $table->dropColumn('cipher_text_2');
            $table->dropColumn('salt_24');
            $table->dropColumn('salt_32');
            $table->dropColumn('salt_any');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ciphers', function (Blueprint $table) {
            $table->renameColumn('cipher_text', 'cipher_text_2');
            $table->text('cipher_text_2');
            $table->text('salt_24');
            $table->text('salt_32');
            $table->text('salt_any');
        });
    }
}
