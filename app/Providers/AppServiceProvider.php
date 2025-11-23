<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AddressParser\DadataParsser;
use App\Services\AddressParser\FakeParsser;
use App\Services\AddressParser\ParsserInterface;
use Dadata\DadataClient;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    
    public function register()
    {
       /*  $this->app->singleton(ParsserInterface::class, function (){
            return new DadataParsser(new DadataClient(
                config('dadata.token'), 
                config('dadata.secret')
            ));
           }); */

           $this->app->singleton(ParsserInterface::class, function (){
            return new FakeParsser();
           });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       /*  \Illuminate\Support\Facades\DB::beforeExecuting(function($query, $params){
            Log::info("DB: $query with params" . json_encode($params));
        }); */
    }
}
