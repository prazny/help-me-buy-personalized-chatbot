<?php

namespace App\Actions;

use App\Models\Product;
use App\Models\Source;
use App\Services\FileParserService\Dto\ParsedProduct;

class StoreProductFromParsedProduct
{


    public function execute(Source $source, ParsedProduct $parsedProduct)
    {
        if ($parsedProduct->category != null) {
            $category = (new StoreCategoryIfNotExist())->execute($parsedProduct->category);
        }

        $product = $source->products()->create([
            'name' => $parsedProduct->name,
            'url' => $parsedProduct->url,
            'img_url' => $parsedProduct->img_urls[0],
            'price' => $parsedProduct->price,
            'category_id' => $category?->id,
        ]);

        $paramValues = [];
        foreach ($parsedProduct->params as $param) {
            $param_name = $param[0];
            $param_value = $param[1];

            // value may have several values eg: small, medium
            foreach (explode(',', $param_value) as $value) {
                $paramValues[] = (new StoreProductParamIfNotExist())->execute($param_name, trim($value));
            }


        }

        $product->paramValues()->saveMany($paramValues);


    }

}
