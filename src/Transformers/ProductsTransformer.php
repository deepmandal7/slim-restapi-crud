<?php

namespace App\Transformers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductsTransformer
{
    /**
     * @param Product $product
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->description,
            'image_url' => $product->image_url,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];
    }

    /**
     * @param Collection $products
     *
     * @return array
     */
    public function transformCollection(Collection $products)
    {
        $data = array();

        foreach ($products as $product) {
            $data[] = ProductsTransformer::transform($product);
        }

        return $data;
    }
}
