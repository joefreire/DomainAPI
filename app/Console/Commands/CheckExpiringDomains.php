<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Domain;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mails\ExpiringDomains;

class CheckExpiringDomains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckExpiringDomains {days}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all domains expiring in next days';

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
     * @return mixed
     */
    public function handle()
    {
        $days = $this->argument('days');
        $dayCheck = Carbon::today()->addDays($days);
        $domains = Domain::where('expiration_at', '<', $dayCheck)->get();
        if ($domains->count() > 0) {
            Mail::to(env('MAIL_EXPIRING', 'freire.joe@gmail.com'))->send(new ExpiringDomains($domains, $days));
        }
    }
}
