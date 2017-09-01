<?php namespace App\Repositories\Interfaces;

Interface RepositoryInterface
{
  public function all($columns = ['*']);

  public function first($columns = ['*']);

  public function find($id, $columns = ['*']);

  public function findByField($field, $value, $columns = ['*']);

  public function findWhere(array $where, $columns = ['*']);

  public function create(array $attributes);

  public function update(array $attributes, $id);

  public function delete($id);

  public function orderBy($column, $direction = 'asc');
}