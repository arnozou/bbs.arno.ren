<?php
namespace App\Transformers;

use App\Category;


class CategoryTransformer extends BaseTransformer {

  public function transform(Category $category)
  {
    return [
      'id'            => $category->id,
      'title'         => $category->title,
      'description'   => $category->description,
      'icon'          => $category->icon,
      'color'         => $category->color,
      'bg_color'      => $category->bg_color,
      'children'      => $category->children,
      // 'posts'         =>
    ];
  }
}