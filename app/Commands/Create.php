<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use LaravelZero\Framework\Commands\Command;

class Create extends Command
{
    protected $signature = 'create {stepSize} {frameRate}';

    protected $description = 'Create the images';

    // no workie
//    public const COLORS = ['#00CCC0' => ['r' => 0, 'g' => 204, 'b' => 192], '#94B3FF' => ['r' => 148, 'g' => 179, 'b' => 255], '#6A5CFF' => ['r' => 106, 'g' => 92, 'b' => 255], '#009EAA' => ['r' => 0, 'g' => 158, 'b' => 170], '#E4ABFF' => ['r' => 228, 'g' => 171, 'b' => 255], '#000000' => ['r' => 0, 'g' => 0, 'b' => 0], '#00756F' => ['r' => 0, 'g' => 117, 'b' => 111], '#00A368' => ['r' => 0, 'g' => 163, 'b' => 104], '#00CC78' => ['r' => 0, 'g' => 204, 'b' => 120], '#2450A4' => ['r' => 36, 'g' => 80, 'b' => 164], '#3690EA' => ['r' => 54, 'g' => 144, 'b' => 234], '#493AC1' => ['r' => 73, 'g' => 58, 'b' => 193], '#515252' => ['r' => 81, 'g' => 82, 'b' => 82], '#51E9F4' => ['r' => 81, 'g' => 233, 'b' => 244], '#6D001A' => ['r' => 109, 'g' => 0, 'b' => 26], '#6D482F' => ['r' => 109, 'g' => 72, 'b' => 47], '#7EED56' => ['r' => 126, 'g' => 237, 'b' => 86], '#811E9F' => ['r' => 129, 'g' => 30, 'b' => 159], '#898D90' => ['r' => 137, 'g' => 141, 'b' => 144], '#9C6926' => ['r' => 156, 'g' => 105, 'b' => 38], '#B44AC0' => ['r' => 180, 'g' => 74, 'b' => 192], '#BE0039' => ['r' => 190, 'g' => 0, 'b' => 57], '#D4D7D9' => ['r' => 212, 'g' => 215, 'b' => 217], '#DE107F' => ['r' => 222, 'g' => 16, 'b' => 127], '#FF3881' => ['r' => 255, 'g' => 56, 'b' => 129], '#FF4500' => ['r' => 255, 'g' => 69, 'b' => 0], '#FF99AA' => ['r' => 255, 'g' => 153, 'b' => 170], '#FFA800' => ['r' => 255, 'g' => 168, 'b' => 0], '#FFB470' => ['r' => 255, 'g' => 180, 'b' => 112], '#FFD635' => ['r' => 255, 'g' => 214, 'b' => 53], '#FFF8B8' => ['r' => 255, 'g' => 248, 'b' => 184], '#FFFFFF' => ['r' => 255, 'g' => 255, 'b' => 255],];
    public const COLORS = [
        '#6D001A' => ['r' => 109, 'g' => 0, 'b' => 26],
        '#BE0039' => ['r' => 190, 'g' => 0, 'b' => 57],
        '#FF4500' => ['r' => 255, 'g' => 69, 'b' => 0],
        '#FFA800' => ['r' => 255, 'g' => 168, 'b' => 0],
        '#FFD635' => ['r' => 255, 'g' => 214, 'b' => 53],
        '#FFF8B8' => ['r' => 255, 'g' => 248, 'b' => 184],
        '#00A368' => ['r' => 0, 'g' => 163, 'b' => 104],
        '#00CC78' => ['r' => 0, 'g' => 204, 'b' => 120],
        '#7EED56' => ['r' => 126, 'g' => 237, 'b' => 86],
        '#00756F' => ['r' => 0, 'g' => 117, 'b' => 111],
        '#009EAA' => ['r' => 0, 'g' => 158, 'b' => 170],
        '#00CCC0' => ['r' => 0, 'g' => 204, 'b' => 192],
        '#2450A4' => ['r' => 36, 'g' => 80, 'b' => 164],
        '#3690EA' => ['r' => 54, 'g' => 144, 'b' => 234],
        '#51E9F4' => ['r' => 81, 'g' => 233, 'b' => 244],
        '#493AC1' => ['r' => 73, 'g' => 58, 'b' => 193],
        '#6A5CFF' => ['r' => 106, 'g' => 92, 'b' => 255],
        '#94B3FF' => ['r' => 148, 'g' => 179, 'b' => 255],
        '#811E9F' => ['r' => 129, 'g' => 30, 'b' => 159],
        '#B44AC0' => ['r' => 180, 'g' => 74, 'b' => 192],
        '#E4ABFF' => ['r' => 228, 'g' => 171, 'b' => 255],
        '#DE107F' => ['r' => 222, 'g' => 16, 'b' => 127],
        '#FF3881' => ['r' => 255, 'g' => 56, 'b' => 129],
        '#FF99AA' => ['r' => 255, 'g' => 153, 'b' => 170],
        '#6D482F' => ['r' => 109, 'g' => 72, 'b' => 47],
        '#9C6926' => ['r' => 156, 'g' => 105, 'b' => 38],
        '#FFB470' => ['r' => 255, 'g' => 180, 'b' => 112],
        '#000000' => ['r' => 0, 'g' => 0, 'b' => 0],
        '#515252' => ['r' => 81, 'g' => 82, 'b' => 82],
        '#898D90' => ['r' => 137, 'g' => 141, 'b' => 144],
        '#D4D7D9' => ['r' => 212, 'g' => 215, 'b' => 217],
        '#FFFFFF' => ['r' => 255, 'g' => 255, 'b' => 255],
    ];

    public const NUM_TILES = 160353104;

    public function handle()
    {
        $stepSize = $this->argument('stepSize');

        if(Storage::exists("result_$stepSize")) {
            $this->stitchFrames($this->argument('frameRate'), $stepSize);
            return;
        }

        $image = imagecreatetruecolor(2000, 2000);

        $colors = array_map(function ($color) use ($image) {
            return imagecolorallocate($image, $color['r'], $color['g'], $color['b']);
        }, self::COLORS);

        imagefill($image, 0, 0, $colors['#FFFFFF']);

        $stream = Storage::readStream('sorted.csv');

        $progress = $this->output->createProgressBar(self::NUM_TILES / $stepSize);

        $iterator = 0;
        $imageIterator = 0;

        Storage::makeDirectory("result_$stepSize");

        $kak = 0;

        while (!feof($stream)) {
            if (!$line = fgetcsv($stream)) {
                continue;
            }

            $coordinates = explode(',', $line[1]);

            if(count($coordinates) === 4) {
                list($x1, $y1, $x2, $y2) = $coordinates;

                $kak++;

                imagefilledrectangle($image, $x1, $y1, $x2, $y2, $colors[$line[2]]);
            } else {
                list($x, $y) = $coordinates;

                imagesetpixel($image, $x, $y, $colors[$line[2]]);
            }

            $iterator++;

            if ($iterator % $stepSize === 0) {
                imagepng($image, 'storage/app/temp.png');
                $imageNumber = sprintf('%010d', $imageIterator);
                rename('storage/app/temp.png', "storage/app/result_$stepSize/$imageNumber.png");
                $imageIterator++;
                $progress->advance();
            }
        }

        fclose($stream);

        $progress->finish();

        $this->stitchFrames($this->argument('frameRate'), $stepSize);
    }

    private function stitchFrames(int $frameRate, int $stepSize)
    {
        if(Storage::exists("storage/app/out_{$stepSize}_{$frameRate}.mp4")) {
            return;
        }

        `ffmpeg -y -framerate {$frameRate} -pattern_type glob -i 'storage/app/result_{$stepSize}/*.png' -c:v libx264 -pix_fmt yuv420p storage/app/out_{$stepSize}_{$frameRate}.mp4`;
    }
}
