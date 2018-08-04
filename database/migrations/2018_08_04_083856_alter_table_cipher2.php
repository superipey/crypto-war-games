<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCipher2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ciphers', function (Blueprint $table) {
            $table->renameColumn('cipher_text', 'cipher_text_1');
            $table->string('cipher_text_2')->after('cipher_text');
            $table->integer('status')->after('real_salt');
            $table->string('salt_8', 8)->change();
            $table->string('salt_16', 16)->change();
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
            $table->renameColumn('cipher_text_1', 'cipher_text');
            $table->dropColumn('cipher_text_2');
            $table->dropColumn('status');
        });
    }
}
