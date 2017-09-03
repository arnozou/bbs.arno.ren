<?php
namespace App\Transformers;

use App\Topic;

class TopicTransformer extends BaseTransformer {

  use Traits\UserTrait;
  
  public function transform(Topic $model)
  {
    return [
      'id'                  => $model->id,
      'title'               => $model->title,
      'body'                => $model->body,
      'creator'             => $this->userTrans($model->user),
      'reply_count'         => $model->reply_count,
      'vote_count'          => $model->vote_count,
      'read_count'          => $model->read_count,
      'last_reply_user_id'  => $model->last_reply_user_id,
      'created_at'          => $model->created_at,
      'updateed_at'         => $model->updated_at,
    ];
  }
}