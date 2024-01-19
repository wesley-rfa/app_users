<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function getAll();
    public function getOne(string $id);
    public function create(array $data);
    public function update(array $data, string $id);
    public function delete(string $id);
}
