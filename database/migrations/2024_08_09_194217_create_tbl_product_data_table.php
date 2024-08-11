<?php declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create('tblProductData', function (Blueprint $table) {
            $table->increments('intProductDataId');

            $table->string('strProductName', '50')
                ->nullable(false);

            $table->string('strProductDesc', '255')
                ->nullable(false);

            $table->string('strProductCode', '10')
                ->nullable(false)
                ->unique();

            $table->unsignedInteger('stock')
                ->default(0);

            $table->unsignedInteger('price')
                ->default(0);

            $table->dateTime('dtmAdded')
                ->nullable();

            $table->dateTime('dtmDiscontinued')
                ->nullable();

            $table->timestamp('stmTimestamp')
                ->useCurrent()
                ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tblProductData');
    }
};
