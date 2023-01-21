<?php

namespace App\Services\FileParserService\Parsers;

use App\Services\FileParserService\Dto\ParsedProduct;
use SimpleXMLElement;

class FileParser
{
    /**
     * @throws \Exception
     */
    public function parseCsv(string $path): array
    {
        $csv = file_get_contents($path);
        $rows = explode("\n", $csv);
        $parsedProducts = [];

        foreach (array_slice($rows, 1) as $row) {
            $cols = str_getcsv($row, ",");
            $params = [];

            for ($i = 6; $i < count($cols); $i += 2) {
                if (empty($cols[$i]) || empty($cols[$i + 1])) continue;
                $params[] = [$cols[$i], $cols[$i + 1]];
            }

            if (count($cols) == 0 || count($cols) == 1) {
                continue;
            };

            if (count($cols) < 6) {
                throw new \Exception("Invalid file");
            }
            $imgs = explode(",", $cols[3]);


            $parsedProducts[] = new ParsedProduct($cols[0], $cols[1], $cols[2], $imgs, $cols[4], floatval($cols[5]), $params);
        }
        return $parsedProducts;
    }

    public function parseXml(string $path): array
    {
        $xml_content = file_get_contents($path);
        $xml = new SimpleXMLElement($xml_content);
        $parsedProducts = [];
        foreach ($xml->product as $product) {
            $imgs = explode(",", (string)$product->image_url);

            $params = [];
            foreach($product->params as $param) {
                $params[] = [(string)$param->name, (string)$param->value];
            }

            $parsedProducts[] = new ParsedProduct($product->id[0], (string)$product->url,
                (string)$product->title[0],
                $imgs, (string)$product->category,
                floatval($product->price),
                $params);
        }

        return $parsedProducts;
    }

}
