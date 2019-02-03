<?php

namespace App\Console\Commands;

use App\Models\MoneyTransaction;
use App\Services\Bank\PrivatBankService;
use Illuminate\Console\Command;

class ProcessTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:process {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send money via bank api';

    protected $bankService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(PrivatBankService $bankService)
    {
        parent::__construct();
        $this->bankService = $bankService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $amount = (int) $this->argument('amount');
        if ($amount) {
            $transactions = MoneyTransaction::where('status', MoneyTransaction::STATUS_PENDING)
                ->limit($amount)->get();
            foreach ($transactions as $transaction) {
                try {
                    $this->bankService->processTransaction($transaction);
                } catch (\Exception $exception) {
                    $transaction->status = MoneyTransaction::STATUS_ERROR;
                    $transaction->info = $exception->getMessage();
                }
            }
        }
    }
}
