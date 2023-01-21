<?php

namespace App\Actions;

use App\Models\Param;
use App\Models\ParamValue;

class StoreProductParamIfNotExist
{
    public function execute(string $param_name, string $value)
    {
        $param = Param::where('name', $param_name)->first();
        if (!$param) {
            $param = Param::create(['name' => $param_name]);
        }

        $paramValue = $param->values()->where('value', $value)->first();
        if (!$paramValue) {
            $paramValue = $param->values()->create([
                'value' => $value,
            ]);
        }

        return $paramValue;
    }

}
