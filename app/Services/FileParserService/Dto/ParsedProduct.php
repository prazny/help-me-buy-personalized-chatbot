<?php

namespace App\Services\FileParserService\Dto;

class ParsedProduct
{
    public array $img_urls;
    public string $url;
    public string $name;
    public string $category;
    public array $params = [];
    public float $price;

    /**
     * @throws \Exception
     */
    public function __construct(string $id, string $url, string $name, array $img_urls, ?string $category, float $price, array $params)
    {
        if(!$this::checkParams($id, $url, $name, $img_urls, $category, $price, $params)) {
            throw new \Exception("Invalid file");
        }
        $this->id = $id;
        $this->url = $url;
        $this->name = $name;
        $this->img_urls = $img_urls;
        $this->category = $category;
        $this->price = $price;
        $this->params = $params;
        //print_r($params);

    }

    static function checkParams(string $id, $url, string $name, array $img_urls, ?string $category, float $price, array $params): array|bool
    {
        $errors = [];
        if (!isset($img_urls[0]) || filter_var($img_urls[0], FILTER_VALIDATE_URL) === FALSE) {
            $errors[] = "Product $id: invalid image url";
        }

        foreach ($params as $item) {
            if (count($item) != 2 && count($item) != 0) $errors[] = "Product $id: invalid params count";
        }

        return empty($errors) ? true : $errors;
    }
}
