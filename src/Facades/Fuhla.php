<?php

namespace Biyosoft\FuhlaLaravelSdk\Facades;

use Illuminate\Support\Facades\Facade;

class Fuhla extends Facade
{
    public static function getFacadeAccessor()
    {
        return "FUHLA";
    }
}
