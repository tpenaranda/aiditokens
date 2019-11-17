<?php

namespace TPenaranda\ModelLog\Facade;

use Illuminate\Support\Facades\Facade;

class ModelToken extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tpenaranda-aiditokens';
    }
}
