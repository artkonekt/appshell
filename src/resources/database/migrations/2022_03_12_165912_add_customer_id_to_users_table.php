<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // If someone has already extended the table,
            // let it happen without errors
            if (!Schema::hasColumn('users', 'customer_id')) {
                $table->intOrBigIntBasedOnRelated('customer_id', Schema::connection(null), 'customers.id')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('customer_id');
        });
    }
}
