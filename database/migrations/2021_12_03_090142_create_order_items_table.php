<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->charset = 'utf8mb4';
                $table->collation = 'utf8mb4_bin';
                $table->id();
                $table->unsignedInteger('quantity')->default(0)->nullable();
                $table->unsignedBigInteger('item_price')->default(0)->nullable();
                $table->timestamps();
            });
        }
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->onDelete('RESTRICT');
        });
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->after('id')
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id', 'product_id']);
        });
        Schema::dropIfExists('order_items');
    }
}
