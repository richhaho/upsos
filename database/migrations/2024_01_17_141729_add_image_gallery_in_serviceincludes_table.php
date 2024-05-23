<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageGalleryInServiceincludesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serviceincludes', function (Blueprint $table) {
            $table->string('image')->nullable()->after('include_service_quantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
            Schema::table('serviceincludes', function (Blueprint $table) {
                $table->dropColumn('image');
            });
    }
}
