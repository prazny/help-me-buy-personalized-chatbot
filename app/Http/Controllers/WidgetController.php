<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyWidgetRequest;
use App\Http\Requests\GetChatPossibilitiesWidgetRequest;
use App\Http\Requests\ShowWidgetRequest;
use App\Http\Requests\StoreWidgetRequest;
use App\Http\Requests\UpdateWidgetChatPossibilitiesRequest;
use App\Http\Resources\WidgetResource;
use App\Models\FileSource;
use App\Models\Param;
use App\Models\ProductCategory;
use App\Models\Widget;
use DB;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->widgets;
    }

    public function store(StoreWidgetRequest $request): WidgetResource
    {
        DB::beginTransaction();
        try {
            $widget = $request->user()->widgets()->create($request->all());

            foreach ($request['file_sources'] as $file_source) {
                $fileSource = FileSource::findOrFail($file_source);
                $fileSource->widgets()->save($widget);
            }

            DB::commit();
            return new WidgetResource($widget);
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show(Widget $widget, ShowWidgetRequest $request)
    {
        return new WidgetResource($widget);
    }

    public function destroy(Widget $widget, DestroyWidgetRequest $request)
    {
        $widget->delete();
        return response(null, 204);
    }

    public function getWidgetChatPossibilities(Widget $widget, GetChatPossibilitiesWidgetRequest $request)
    {
        $sources = $widget->fileSources;
        $products = [];
        foreach ($sources as $source) {
            $products = array_merge($products, $source->products()->with('paramValues')->get()->toArray());
        }

        $categories_id = [];
        $params_id = [];

        foreach ($products as $product) {
            if (!isset($categories_id[$product['category_id']])) $categories_id[$product['category_id']] = $product['category_id'];

            foreach ($product['param_values'] as $value) {
                if (!isset($params_id[$value['param_id']])) $params_id[$value['param_id']] = $value['param_id'];
            }
        }

        $categories_id = array_unique($categories_id);
        $params_id = array_unique($params_id);

        $params = Param::whereIn('id', $params_id)->with('values')->get();
        $categories = ProductCategory::whereIn('id', $categories_id)->get();

        return response()->json([
                'stories' => $widget->stories,
                'possibilities' => [
                    'categories' => $categories,
                    'params' => $params
                ]
            ]);
    }

    public function updateWidgetChatPossibilities(Widget $widget, UpdateWidgetChatPossibilitiesRequest $request)
    {
        $widget->update($request->all());
        return response(["message" => "ok"], 201);
    }


}
