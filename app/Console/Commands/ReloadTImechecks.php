<?php

namespace App\Console\Commands;

use App\Models\MailCheck;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReloadTImechecks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:reloadTimechecks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $repeatedTimechecks = MailCheck::select('timecheck', DB::raw('COUNT(*) as cantidad_repeticiones'))
            ->groupBy('timecheck')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($repeatedTimechecks as $timecheckGroup) {
            $timecheckValue = $timecheckGroup->timecheck;

            $duplicates = MailCheck::where('timecheck', $timecheckValue)->get();

            foreach ($duplicates as $key => $duplicate) {
                if ($key === 0) {
                } else {
                    if ($duplicate->checked) {
                        do {
                            $newTimecheckValue = $this->generateUniqueTimecheck();
                        } while (MailCheck::where('timecheck', $newTimecheckValue)->exists());

                        $duplicate->update(['timecheck' => $newTimecheckValue]);
                    }else{
                        $duplicate->delete();
                    }
                }
            }
        }
    }


    function generateUniqueTimecheck()
    {

        return time();
    }
}
