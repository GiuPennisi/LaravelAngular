<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Doctrine\DBAL\Types\Type;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('msgSubject');
            $table->string('msgBody');
            $table->dateTime('msgSenddate');
            $table->integer('user_id')->unsigned(); /*autor del mensaje*/
            $table->integer('destinatario_id')->unsigned(); /*quien recibe el mensaje*/
            $table->integer('folder_id')->unsigned();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
