<?php
namespace App\Repositories\Traits;

trait UpdatePaginateTrait
{
  
  public function updatePaginate($pageSize, $after = null, $before = null)
  {
    $where = [];
    if ($after) {
      $where[] = ['updated_at', '>', $after];
    }
    if ($before) {
      $where[] = ['updated_at', '<', $before];
      if (!$after) {
        $this->model->orderBy('updated_at', 'desc');
      }
    }
    $this->model->where($where)->limit($pageSize);
  }
}