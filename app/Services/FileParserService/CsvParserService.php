<?php

namespace App\Services\FileParserService;

class CsvParserService
{
    public function __construct()
    {

    }

    private function getFileFromNetwork() {

    }
    public function parseCsvNetwork(string $url) {
        if (($handle = fopen("test.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                echo "<p> $num fields in line $row: <br /></p>\n";
                $row++;
                for ($c=0; $c < $num; $c++) {
                    echo $data[$c] . "<br />\n";
                }
            }
            fclose($handle);
        }
    }

}
