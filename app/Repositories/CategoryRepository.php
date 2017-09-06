<?php namespace App\Repositories;


use App\Repositories\Interfaces\CategoryInterface;
use App\Category;

class CategoryRepository extends Repository Implements CategoryInterface {

  /*public function all(Array $columns = ['*'])
  {
    return Category::all($columns);
  }*/

  public function model()
  {
    return \App\Category::class;
  }

  public function getChildren($parentId)
  {
    return Category::where('parent_id', $parentId)->get();
  }

  public function loadLastReplies(\Illuminate\Database\Eloquent\Collection $categories)
  {
    $ids = [];
    foreach ($categories as $category) {
      $category->last_reply_id = $category->redisLoadLastReplyId();
      $ids[] = $category->last_reply_id;
    }
    // dump($categories);
    $replies = \App\Reply::whereIn('id', $ids)->get();
    // dump($replies);
    foreach ($categories as $category) {
      // dump($category->last_reply_id, $replies->find($category->last_reply_id));
      if ($reply = $replies->find($category->last_reply_id)) {
        // dump('run');
        $category->setRelation('last_reply', $reply);
        // $category->last_reply = $reply;
      }
    }
    // dump($categories, 'after get');
    return $categories;
  }
}