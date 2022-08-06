<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use PDOException;

class UnreliableDBQueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function () {
            if (env("APP_ENV") === "local") {
                if (lcg_value() < 0.5) {
                    throw new PDOException("DB: Connection refused, sorry ^^'");
                }
            }
        });}
}
