<?php

namespace App\Http\Controllers;

use App\Services\RecentlyProducts;

class ProductsController extends Controller
{
    /**
     * Show recently products list.
     *
     * @return array
     */
    public function show()
    {
        $recentlyProducts = new RecentlyProducts();
        return $recentlyProducts->show();
    }

    /**
     * Store recently product in list.
     *
     * @param int $productId
     * @return array
     */
    public function store($productId)
    {
        $recentlyProducts = new RecentlyProducts();
        return $recentlyProducts->store($productId);
    }

    /**
     * Update recently product in list.
     *
     * @param int $productId
     * @return array
     */
    public function update($productId)
    {
        $recentlyProducts = new RecentlyProducts();
        return $recentlyProducts->update($productId);
    }

    /**
     * Delete recently product from list.
     *
     * @param int $productId
     * @return array
     */
    public function delete($productId)
    {
        $recentlyProducts = new RecentlyProducts();
        return $recentlyProducts->delete($productId);
    }
}

