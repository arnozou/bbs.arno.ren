<?php namespace App\Repositories\Interfaces;

Interface CategoryInterface
{
  public function all();

  public function getChildren($parentId);

  public function loadLastReplies(\Illuminate\Database\Eloquent\Collection $categories);
}