<?php 

namespace Senses\Gdpr;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class Gdpr 
{
    public function get()
    {
        $config = config('gdpr');
        if(Cookie::has($config['cookie_name'])) {
            return json_decode(Cookie::get($config['cookie_name']));
        }
        
        return $config['defaults'];
    }

    // protected function set($input)
    // {
    //     $config = config('gdpr');

    //     $gdpr = $this->get();

    //     $gdpr = array_merge($gdpr, $input);
    // }

    public function config()
    {
        return config('gdpr');
    }
   
    public function allows($category)
    {
        if(!config('gdpr')['enabled']) return true;

        $config = config('gdpr');
        $consented = false;
        if(Cookie::has($config['cookie_name'])) {
            $cookie = json_decode(Cookie::get($config['cookie_name']), true);
            $consented = !!Arr::get($cookie, $category);
        }
        return $consented;
    }
}