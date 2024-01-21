<?php

namespace App\Facades;

use App\Services\Site\CartService;
use Illuminate\Support\Facades\Facade;

class CartFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CartService::class;
    }
}
