<?php

 namespace Jomanza\Rating\Contracts;

 interface Rateable {
    public function raters($model = null);
    public function averageRating();
 }