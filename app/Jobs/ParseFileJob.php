<?php

namespace App\Jobs;

use App\Actions\StoreProductFromParsedProduct;
use App\enums\FileSourceExtensionEnum;
use App\enums\FileSourceTypeEnum;
use App\Models\FileSource;
use App\Services\FileParserService\Parsers\FileParser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ParseFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private FileSource $fileSource;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FileSource $fileSource)
    {
        $this->fileSource = $fileSource;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $fileParser = new FileParser();
        $products = null;

        $file = $this->fileSource->getMedia('file')->first();

        try {
            if ($file->mime_type == 'text/csv') {
                $products = $fileParser->parseCsv($this->fileSource->getMedia('file')->first()->getPath());
            } else if($file->mime_type == 'text/xml') {
                $products = $fileParser->parseXml($this->fileSource->getMedia('file')->first()->getPath());
            }

            foreach ($products as $product) {
                (new StoreProductFromParsedProduct())->execute($this->fileSource, $product);
            }

            $this->fileSource->is_parsed = 1;
            $this->fileSource->is_correct = 1;
            $this->fileSource->save();
        } catch (\Exception $e) {
            $this->fileSource->is_parsed = 1;
            $this->fileSource->is_correct = 0;
            $this->fileSource->save();
            \Log::warning($e);
            throw $e;
        }


    }
}
