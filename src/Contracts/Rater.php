<?php

 namespace Jomanza\Rating\Contracts;

 interface Rater {
    public function ratings($model = null);
    public function hasRated($model): bool;
    public function rate($model, $mensagem = null, $rating): bool;
    public function updateRatingFor($model, $newRating);
    public function unrate($model): bool;
 }