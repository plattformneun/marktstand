<?php

namespace Marktstand\Managers;

abstract class Manager
{
    /**
     * Define the fillable fields.
     *
     * @return array
     */
    abstract protected function fillable();

    /**
     * Set fillable fields for the given model.
     *
     * @param  Illuminate\Database\Eloquent\Model $model
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function makeFillable($model)
    {
        return $model->fillable($this->fillable());
    }
}
