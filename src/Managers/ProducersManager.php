<?php

namespace Marktstand\Managers;

use Marktstand\Users\Producer;

class ProducersManager extends Manager
{
    /**
     * Find a producer by username.
     *
     * @param  string $username
     * @param  array $with
     * @return Marktstand\Users\Producer
     */
    public function fromUsername($username, array $with = [])
    {
        return Producer::with($with)->where('username', $username)->firstOrFail();
    }

    /**
     * Find a producer by username.
     *
     * @param  int $id
     * @param  array $with
     * @return Marktstand\Users\Producer
     */
    public function fromId($id, array $with = [])
    {
        return Producer::with($with)->findOrFail($id);
    }

    /**
     * Define the fillable fields.
     *
     * @return array
     */
    protected function fillable()
    {
        return [];
    }
}
