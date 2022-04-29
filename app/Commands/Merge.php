<?php

namespace App\Commands;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Spatie\Async\Pool;
use Storage;

class Merge extends Command
{
    protected $signature = 'merge';

    protected $description = 'Merges all files to one file';

    public function handle()
    {
        //todo: use multithreading

        $files = collect(Storage::files('files'))->sort();

        $tiles = fopen('storage/app/tiles.csv', 'w');

        foreach ($files as $file) {
            $this->info("Merging $file...");

            $stream = Storage::readStream($file);
            $header = fgetcsv($stream);

            while (!feof($stream)) {
                if (!$line = fgetcsv($stream)) {
                    continue;
                }

                $tile = array_combine($header, $line);

                fputcsv($tiles, [
                    Carbon::parse($tile['timestamp'])->getPreciseTimestamp(3),
                    $tile['coordinate'],
                    $tile['pixel_color'],
                ]);
            }

            fclose($stream);
        }

        $this->info('Sorting...');
        `gsort -t',' -n -k2 --parallel=12 storage/app/tiles.csv > storage/app/sorted.csv`;
    }
}
