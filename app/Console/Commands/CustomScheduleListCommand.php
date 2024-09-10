<?php

namespace App\Console\Commands;

use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;

class CustomScheduleListCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'schedule:list {--timezone= : The timezone that times should be displayed in}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List the scheduled commands';

    /**
     * Execute the console command.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function handle(Schedule $schedule)
    {
        $rows = [];
        $defaultTimezone = config('app.timezone', 'UTC'); // Valor por defecto para la zona horaria

        foreach ($schedule->events() as $event) {
            $timezone = $event->timezone ?? $defaultTimezone;

            // Validar que el timezone sea un objeto DateTimeZone
            $timezoneOption = $this->option('timezone');
            if ($timezoneOption && !empty($timezoneOption)) {
                $timezone = $timezoneOption;
            }

            try {
                $nextRunDate = (new CronExpression($event->expression))
                    ->getNextRunDate(Carbon::now()->setTimezone($timezone))
                    ->setTimezone($timezone)
                    ->format('Y-m-d H:i:s P');
            } catch (\Exception $e) {
                $nextRunDate = 'Error: ' . $e->getMessage();
            }

            $rows[] = [
                $event->command,
                $event->expression,
                $event->description,
                $nextRunDate,
            ];
        }

        $this->table([
            'Command',
            'Interval',
            'Description',
            'Next Due',
        ], $rows);
    }
}
