<?php

namespace App\Services\FileParserService\Parsers;

use App\Services\FileParserService\Dto\ParsedProduct;

interface ParserInterface
{
    public function __construct();

    public function getProducts(): ParsedProduct;


}
