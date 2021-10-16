<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id()->unsigned(true);

            $table->foreignId('account_id')
                ->constrained('accounts')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->unsignedDecimal('amount', 12);
            $table->string('description', 255);
            $table->longText('check_image')->nullable();
            $table->enum('type', ['INCOME', 'EXPENSE']);
            $table->enum('status', ['PENDING', 'ACCEPTED', 'REJECTED']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
