<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\Type;

class AddFKUserIDMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('destinatario_id')->references('id')->on('users');
            $table->foreign('folder_id')->references('id')->on('folders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('message_folder_id_foreign');
            $table->dropForeign('messages_destinatario_id_foreign');
            $table->dropForeign('messages_user_id_foreign');
        });
    }
}
