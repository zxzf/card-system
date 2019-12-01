<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateOrdersTable extends Migration { public function up() { Schema::create('orders', function (Blueprint $sp79d26d) { $sp79d26d->increments('id'); $sp79d26d->integer('user_id')->index(); $sp79d26d->string('order_no', 128)->index(); $sp79d26d->integer('product_id'); $sp79d26d->string('product_name')->nullable(); $sp79d26d->integer('count'); $sp79d26d->string('ip')->nullable(); $sp79d26d->string('customer', 32)->nullable(); $sp79d26d->string('contact')->nullable(); $sp79d26d->text('contact_ext')->nullable(); $sp79d26d->tinyInteger('send_status')->default(App\Order::SEND_STATUS_UN); $sp79d26d->text('remark')->nullable(); $sp79d26d->integer('cost')->default(0); $sp79d26d->integer('price')->default(0); $sp79d26d->integer('discount')->default(0); $sp79d26d->integer('paid')->default(0); $sp79d26d->integer('fee')->default(0); $sp79d26d->integer('system_fee')->default(0); $sp79d26d->integer('income')->default(0); $sp79d26d->integer('pay_id'); $sp79d26d->string('pay_trade_no')->nullable(); $sp79d26d->integer('status')->default(\App\Order::STATUS_UNPAY); $sp79d26d->string('frozen_reason')->nullable(); $sp79d26d->string('api_out_no', 128)->nullable(); $sp79d26d->text('api_info')->nullable(); $sp79d26d->dateTime('paid_at')->nullable(); $sp79d26d->timestamps(); }); } public function down() { Schema::dropIfExists('orders'); } }