<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updatehistory:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update bet history five minutes after being placed';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
