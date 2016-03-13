<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
class ValidatorServiceProvider extends ServiceProvider {

    public function boot()
    {
        $this->app['validator']->extend('arrayCountMax', function ($attribute, $value, $parameters)
        {
            $max = $parameters[0];
            $arr_count = count(explode(',',$value));
            if($arr_count <= $max)
                return true;
            else
                return false;
        });

        Validator::replacer('arrayCountMax', function($message, $attribute, $rule, $parameters) {
            return "Must not have more than $parameters[0] $attribute ";
        });

        $this->app['validator']->extend('arrayCountMin', function ($attribute, $value, $parameters)
        {
            $min = $parameters[0];
            $arr_count = count(explode(',',$value));
            if($arr_count >= $min)
                return true;
            else
                return false;
        });

        Validator::replacer('arrayCountMin', function($message, $attribute, $rule, $parameters) {
            return "Must not have less than $parameters[0] $attribute ";
        });
    }

    public function register()
    {
        //
    }
}