<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('priority_id');
            $table->unsignedInteger('agent_id')->nullable();
            $table->string('subject');
            $table->longText('body');
            $table->timestamp('closed_at')->nullable();
            $table->timestamp('reminded_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ticket_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('ticket_priorities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('ticket_id');
            $table->unsignedInteger('is_internal')->default(0);
            $table->longText('body');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
            $table->unsignedInteger('ticket_id');
            $table->string('disk_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_extension')->nullable();
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
        //
    }
}
