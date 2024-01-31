<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Campaign;
use Illuminate\Console\Command;

class delpayTimeCreateCampainCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:delay-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delay time create a new campain';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Campaign::where('id', 1)->delete();
    }
}
