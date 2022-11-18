<?php

namespace App\Models;

use Slim\Http\Request;

class Product extends BaseModel
{
    /**
     * @var array
     */
    public $fillable = [
        'title',
        'description',
        'image_url'
    ];

    /**
     * @param Request $request
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function addProduct(Request $request)
    {
        // echo "addProduct";
        $product = new Product();
        // echo "addProduct";
        $inputs = $request->getParams();
        // var_dump($product);
        foreach ($inputs as $col => $val) {

            // continue if the provided field isn't recognisable

            if (!in_array($col, $product->fillable)) {
                continue;
            }

            // set field as null if empty

            $product->$col = !empty($val) ? $val : null;
        }
        echo "addProductttt";
        var_dump($product->save());
        echo "addProduct";
        if ($product->save()) {
            return Product::find($product->id);
        } // refetch full product model

        return false;
    }

    /**
     * @param Request $request
     * @param array   $args
     *
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function updateProduct(Request $request, $args)
    {
        $inputs = $request->getParams();

        $product = Product::find($args['id']);

        foreach ($inputs as $col => $val) {

            // continue if the provided field isn't recognisable

            if (!in_array($col, $product->fillable)) {
                continue;
            }

            // set field as null if empty

            $product->$col = !empty($val) ? $val : null;
        }

        if ($product->save()) {
            return Product::find($product->id);
        } // refetch full product model

        return false;
    }
}
