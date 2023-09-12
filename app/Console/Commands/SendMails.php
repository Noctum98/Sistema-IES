<?php

namespace App\Console\Commands;

use App\Mail\VerifiedPreEnroll;
use App\Models\Preinscripcion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sendMails';

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
        $preinscripciones = Preinscripcion::where([
            'updated_at', '<', '2023-09-6'
        ]);

        $preinscripciones = $preinscripciones->where('estado','verificado')->get();

        $this->output->progressStart(count($preinscripciones));
        foreach ($preinscripciones as $preinscripcion) {
            Mail::to($preinscripcion->email)->queue(new VerifiedPreEnroll($preinscripcion));
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();

    }
}
