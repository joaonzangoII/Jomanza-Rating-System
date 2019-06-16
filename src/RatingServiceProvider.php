<?php
 namespace Jomanza\Rating;

 use Illuminate\Support\ServiceProvider;

 class RatingServiceProvider extends ServiceProvider {


    public function boot() {
        $this->publishes([__DIR__. '/../config/rating.php' => config_path('rating.php')], 'config');
        $this->publishes([__DIR__. '/../database/migrations/2019_04_06_033922_create_ratings_table.php' => database_path('migrations/2019_04_06_033922_create_ratings_table.php')], 'migration');
    }

    /**
    * Register bindings in the container.
    * 
    *@return void
    */

    public function register() {

    }

 }