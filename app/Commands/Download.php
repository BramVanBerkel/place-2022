<?php

namespace App\Commands;

use CurlHandle;
use DOMElement;
use Illuminate\Support\Facades\Http;
use LaravelZero\Framework\Commands\Command;
use Storage;
use Symfony\Component\DomCrawler\Crawler;

class Download extends Command
{
    protected $signature = 'download';

    protected $description = 'Download all the required files';

    public const INDEX_URL = 'https://placedata.reddit.com/data/canvas-history/index.html';

    public function handle()
    {
        Storage::delete('files/download.tmp');

        $index = Http::get(self::INDEX_URL)->body();

        $crawler = new Crawler($index);

        foreach ($crawler->filter('body > ul > li') as $element) {
            /** @var DOMElement $element */
            $url = $element->firstChild->getAttribute('href');

            // get the file name from the url
            $fileName = explode('/', parse_url($url)['path'])[3];

            // remove .gzip from the end
            $explode = explode('.', $fileName);
            array_pop($explode);
            $fileName = implode('.', $explode);

            if(Storage::exists("files/$fileName")) {
                continue;
            }

            $this->info("Downloading {$url}");

            $this->download($url, $fileName);

            $this->newLine();
        }
    }

    private function download(string $url, string $fileName)
    {
        Storage::makeDirectory('files');

        $fp = fopen('storage/app/files/download.tmp', 'w+');

        $progress = $this->output->createProgressBar();
        $progress->setFormat('%current%/%max% [%bar%] %percent:3s%% %speed%');

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_NOPROGRESS, false); // needed to make progress function work
        curl_setopt($ch, CURLOPT_PROGRESSFUNCTION, static function(CurlHandle $handle, int $downloadTotal, int $downloadNow) use($progress) {
            $progress->setMaxSteps($downloadTotal / 1_000_000);

            $progress->setProgress($downloadNow / 1_000_000);

            $MBs = round(curl_getinfo($handle, CURLINFO_SPEED_DOWNLOAD) / 1_000_000, 2);
            $progress->setMessage("{$MBs} MB/s", 'speed');
        });

        curl_exec($ch);

        curl_close($ch);

        $file = gzopen('storage/app/files/download.tmp', 'rb');
        $out_file = fopen("storage/app/files/$fileName", 'wb');

        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, 4096));
        }

        fclose($out_file);
        gzclose($file);
    }
}
