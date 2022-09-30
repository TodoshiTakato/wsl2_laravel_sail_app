<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_bin';
                $table->id()->index();
                $table->string('name', 50)->nullable();
                $table->text('description')->nullable();
                $table->unsignedBigInteger('price')->default(0)->nullable();
                $table->unsignedTinyInteger('status')->nullable();
                $table->timestamps();
            });
        }

        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();
//            $table->foreign('category_id')->references('id')->on('Categories')->onDelete('cascade');
//            $table->foreignId('category_id')->nullable()->constrained('Categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('products');
    }
}
