<?php namespace App\Repositories\Interfaces;

Interface CategoryInterface
{
  public function all();

  public function getChildren($parentId);
}