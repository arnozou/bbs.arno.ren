<?php namespace App\Repositories;


use App\Repositories\Interfaces\CategoryInterface;
use App\Category;
class CategoryRepository Implements CategoryInterface {

  public function all()
  {
    return Category::all();
  }

  public function getChildren($parentId)
  {
    return Category::where('parent_id', $parentId)->get();
  }
}