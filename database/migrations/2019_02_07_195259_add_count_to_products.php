<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class AddCountToProducts extends Migration { public function up() { if (!Schema::hasColumn('products', 'count_all')) { Schema::table('products', function (Blueprint $sp79d26d) { $sp79d26d->integer('count_all')->default(0)->after('count_sold'); }); App\Product::whereRaw('1')->update(array('count_sold' => 0, 'count_all' => 0)); \App\Card::selectRaw('`product_id`,SUM(`count_sold`) as `count_sold`,SUM(`count_all`) as `count_all`')->groupBy('product_id')->orderByRaw('`product_id`')->chunk(100, function ($sp5b0739) { foreach ($sp5b0739 as $sp1d0a77) { \App\Product::where('id', $sp1d0a77->product_id)->update(array('count_sold' => $sp1d0a77->count_sold, 'count_all' => $sp1d0a77->count_all)); } }); } } public function down() { if (Schema::hasColumn('products', 'count_all')) { Schema::table('products', function (Blueprint $sp79d26d) { $sp79d26d->dropColumn(array('count_all')); }); } } }