<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_bin';
                $table->id()->index();
                $table->string('name', 50)->nullable();
                $table->timestamps();
            });
        }
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('parent_id')
                ->after('id')
                ->nullable()
                ->constrained('categories')
                ->cascadeOnDelete();
//            $table->foreignId('parent_id')->nullable()->constrained()->onDelete('cascade');
//            $table->foreign('parent_id')->references('id')->on('Categories')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });
        Schema::dropIfExists('categories');
    }
}
