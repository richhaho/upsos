<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductImageInServiceadditionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serviceadditionals', function (Blueprint $table) {
            $table->string('product_image')->nullable()->after('additional_service_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serviceadditionals', function (Blueprint $table) {
            $table->dropColumn('product_image');
        });
    }
}
