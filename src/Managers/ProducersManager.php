<?php

namespace Marktstand\Managers;

use Marktstand\Users\Producer;

class ProducersManager extends Manager
{
    /**
     * Pagination count.
     *
     * @var int
     */
    protected $paginate;

    /**
     * The related models that should be eager loaded.
     *
     * @return self
     */
    public function paginate($count)
    {
        $this->paginate = $count;

        return $this;
    }

    /**
     * Fetch all producers.
     *
     * @param  array $with
     * @return Marktstand\Users\Producer
     */
    public function all(array $with = [])
    {
        if ($this->paginate) {
            return Producer::with($with)->paginate($this->paginate);
        }
        
        return Producer::with($with)->get();
    }

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
