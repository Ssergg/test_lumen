<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Carbon;

class RecentlyProducts
{
    const DEFAULT_PRODUCT_LIST = ['Default product list'];
    const STORAGE_DAYS = 10;
    const MAX_NUMBER = 100;

    /**
     * Store recently product in list.
     *
     * @param int $productId
     * @return array
     */
    public function store($productId)
    {
        $product = [$productId => time()];

        $products = Cache::store('redis')->get($this->getUserKey());

        if(!is_null($products)) {
            Arr::pull($products, $productId);
        } else $products = [];

        $products = $this->checkList($product + $products);

        Cache::store('redis')->put($this->getUserKey(), $products, Carbon::now()->addDays(self::STORAGE_DAYS));

        return array_keys($products);
    }

    /**
     * Show recently products list.
     *
     * @return array
     */
    public function show()
    {
        $products = Cache::store('redis')->get($this->getUserKey());

        if(!empty($products)){
            return array_keys($this->checkList($products));
        }
        return $this->getDefaultList();
    }

    /**
     * Update recently product in list.
     *
     * @param int $productId
     * @return array
     */
    public function update($productId)
    {
        return $this->store($productId);
    }

    /**
     * Delete recently product from list.
     *
     * @param int $productId
     * @return array
     */
    public function delete($productId)
    {
        $products = Cache::store('redis')->get($this->getUserKey());

        if($products and array_key_exists($productId, $products)){

            $ttl = $products[array_key_first($products)] + self::STORAGE_DAYS*24*3600 - time();

            Arr::pull($products, $productId);

            Cache::store('redis')->put($this->getUserKey(), $products, $ttl);
        }
        return array_keys($products);
    }

    /**
     * Return authenticated user id.
     *
     * @return int
     */
    protected function getAuthenticatedUser()
    {
        return 1;
    }

    /**
     * Return default recently products list.
     *
     * @return array
     */
    protected function getDefaultList()
    {
        return self::DEFAULT_PRODUCT_LIST;
    }

    /**
     * Form recently products list.
     *
     * @param array $products
     * @return array
     */
    protected function checkList($products){
        return array_slice(array_filter($products, function ($expire){
            return  $expire > (time() - self::STORAGE_DAYS*24*3600);
        }), 0, self::MAX_NUMBER, true);
    }

    /**
     * Get user key.
     *
     * @return string
     */
    protected function getUserKey(){
        return 'user-' . $this->getAuthenticatedUser();
    }
}

