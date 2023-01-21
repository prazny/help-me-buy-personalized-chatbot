<?php

namespace App\Services\FileParserService\Parsers;

use App\Services\FileParserService\Dto\ParsedProduct;

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

}
