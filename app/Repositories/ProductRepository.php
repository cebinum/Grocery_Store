<?php

namespace App\Repositories;

use App\Models\Product;


/**
 * Only approved events.
 *
 * @package App\Repositories
 */
class ProductRepository
{

    /**
     * Get a list of all publised candidate profiles
     * @return Collection
     */
    public function publishedProducts()
    {
        return Product::isPublished()
            ->latest()
            ->get()->shuffle();
    }

    /**
     * Get a list of all products related to a particular product
     * @return Collection
     */
    public function relatedProducts($product)
    {
        return $this->publishedProducts()
            ->where('id', '!=', $product->id)
            ->where('category_id','=', $product->category_id)->take(4);
    }
}
