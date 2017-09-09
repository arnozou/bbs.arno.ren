<?php
namespace App\Transformers;

use App\Category;


class CategoryTransformer extends BaseTransformer {

  public function transform(Category $category)
  {
    $replyT = new ReplyTransformer();
    return [
      'id'            => $category->id,
      'title'         => $category->title,
      'description'   => $category->description,
      'icon'          => $category->icon,
      'color'         => $category->color,
      'bg_color'      => $category->bg_color,
      'parent_id'     => $category->parent_id,
      'children'      => $category->relationloaded('children') ? $category->children : null,
      'last_reply'    => $category->relationloaded('last_reply') 
      ? $replyT->transform($category->getRelation('last_reply')) : null,
      // 'posts'         =>
    ];
  }
}