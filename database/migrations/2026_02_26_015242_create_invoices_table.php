<?php

use App\Enums\InvoiceStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('contract_id')
                  ->nullable();
            $table->foreign('contract_id')
                  ->references('id')
                  ->on('contracts')
                  ->cascadeOnDelete();
            
            $table->string('invoice_number');
            $table->decimal('subtotal');
            $table->decimal('tax_amount');
            $table->decimal('total');
            $table->enum('status', InvoiceStatusEnum::values());
            $table->date('due_date');
            $table->date('paid_at');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
