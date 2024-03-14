<?php

namespace Infrastructure\Facades;

use Illuminate\Support\Facades\Facade;
use Infrastructure\FileService;


class FileFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return FileService::class;
    }
}
