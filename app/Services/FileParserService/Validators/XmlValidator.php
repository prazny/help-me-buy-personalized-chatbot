<?php

namespace App\Services\FileParserService\Validators;

use DOMDocument;

class XmlValidator
{
    /**
     * @throws \Exception
     */
    public function validate(string $xml_content): bool
    {
        $xsd_source =__DIR__ . "/../schemas/xml-schema.xsd";
        $xml = new DOMDocument('1.0', 'utf-8');
        $xml->loadXML($xml_content, LIBXML_NOBLANKS);
        if (!$xml->schemaValidate($xsd_source)) {
            $errors = libxml_get_errors();
            $results = "";
            foreach ($errors as $error) {
                $results .= "Error $error->code  (Line:{$error->line})\n";
            }
            throw new \Exception($results);
        }

        return true;
    }
}

