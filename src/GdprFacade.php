<?php 

namespace Senses\Gdpr;

use Illuminate\Support\Facades\Facade;

class GdprFacade extends Facade 
{
    protected static function getFacadeAccessor() 
    {
        return 'gdpr';
    }
}