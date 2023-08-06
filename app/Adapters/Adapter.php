<?php

namespace App\Adapters;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface Adapter{

    
    /**
     * Get list of elements
     * @return Collection
     */
    public static function getList() : Collection;

    /**
     * Find one element by its id
     * @param int $id
     * @return Model|null Found model or null if not found
     */
    public static function findById(int $id) : Model|null;

    /**
     * Creates new element and persists it
     * @param array<mixed> $params Array of model's needed fields
     * @return bool|Model Created model or false if fails
     */
    public static function create(array $params) : bool|Model;

    /**
     * Get number of elements
     * @return int
     */
    public static function getCount() : int;
}