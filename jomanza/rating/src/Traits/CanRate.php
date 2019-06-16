<?php

namespace Jomanza\Rating\Traits;

use Jomanza\Rating\Contracts\Rater;
use Jomanza\Rating\Contracts\Rating;

trait CanRate
{

     /**
     * Relationship for models that this model currently rated.
     * 
     * @params Model $model The model types of the results.
     * @return morphToMany The relationship.
    */

    public function ratings($model = null)
    {
        return $this->morphToMany(($model) ?:$this->getMorphClass(), 'rater', 'ratings', 'rater_id', 'rateable_id')
                    ->withPivot('rateable_type', 'rating')
                    ->wherePivot('rateable_type', ($model) ?: $this->getMorphClass())
                    ->wherePivot('rater_type', ($model) ?: $this->getMorphClass());
    }

    /**
     * Check if the current model is rating another model.
     *
     * @param Model $model The model which will be checked against.
     * @return bool
     */
    public function hasRated($model): bool
    {

        // if (! $model instanceof Rater && ! $model instanceof Rating) {
        //     return false;
        // }
        // dd(is_null($this->ratings($model->getMorphClass())->find($model->getKey())));
        return (bool) !is_null($this->ratings($model->getMorphClass())->find($model->getKey()));
    }

        /**
     * Rate a certain model.
     *
     * @param Model $model The model which will be rated.
     * @param float $rate The rate amount.
     * @return bool
     */

    public function rate($model = null, $mensagem = null, $rating) : bool
    {
        // if(! $model instanceof Rater && ! $model instanceof Rating) {
        //     return false;
        // }
        if($this->hasRated($model)) {
            return false;
        }

        $this->ratings()->attach($this->getKey(), [
            'rater_id' => $this->getKey(),
            'rateable_type' => $model->getMorphClass(),
            'rateable_id' => $model->getKey(),
            'rating' => (float) $rating,
            'mensagem' => $mensagem,
        ]);

        return true;
    }

    /**
     * Rate a certain model
     * 
     * @params Model $model The model which will be rated.
     * @params float $rate The rate amount.
     * @return bool.
    */

    public function updateRatingFor($model, $newRating) {    
        // if (! $model instanceof Rater && ! $model instanceof Rating) {
        //     return false;
        // }
        
        if (! $this->hasRated($model)) {
            return $this->rate($model, $newRating);
        }

        $this->unrate($model);
        return $this->rate($model, $newRating);
    }

      /**
     * Unrate a certain model
     * 
     * @params Model $model The model which will be unrated.
     * @return bool.
    */

    public function unrate($model) : bool {
        // if (! $model instanceof Rater && ! $model instanceof Rating) {
        //     return false;
        // }

        if(!$this->hasRated($model)) {
            return false;
        }
        return (bool) $this->ratings($model->getMorphClass())->detach($model->getKey());
    }
}