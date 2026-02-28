<?php

namespace App\Console\Commands;

use App\Enums\InvoiceStatusEnum;
use App\Models\Invoice;
use Illuminate\Console\Command;

class MarkOverdueInvoicesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:mark-overdue-invoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command that marks overdue invoices';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $todayDate = now()->toDateString();

        $overdueInvoices = Invoice::query()->where('due_date', '<', $todayDate)
            ->where('status', '=', InvoiceStatusEnum::PENDING->value);

        $isUpdated = $overdueInvoices->update([
            'status' => InvoiceStatusEnum::OVERDUE->value
        ]);

        if ($isUpdated)
            $this->info('The invoices are marked as overdue');
        else
            $this->info('No invoices are marked as overdue');
    }
}
