<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository implements RepositoryInterface
{
    public function __construct(
        private User $model = new User
    ) {
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function getOne(string $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, string $id)
    {
        return $this->model->findOrFail($id)->update($data);
    }

    public function delete(string $id)
    {
        $this->model->findOrFail($id)->delete();
    }
}
