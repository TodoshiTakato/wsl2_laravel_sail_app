<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('tasks')) {
            Schema::create('tasks', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_bin';
                $table->id();
                $table->string('name', 255)->nullable();
                $table->text('details')->nullable();
                $table->unsignedtinyInteger('status')->nullable();
                $table->unsignedtinyInteger('priority')->nullable();
                $table->timestamp('start_time')->nullable();
                $table->timestamp('finish_time')->nullable();
                $table->unsignedInteger('time_spent')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('user_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
//                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
//                $table->foreignId('rating_id')->nullable()->constrained('ratings')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('tasks');
    }
}
