<?php
namespace App\Transformers;

use App\Reply;

class ReplyTransformer extends BaseTransformer {

  use Traits\UserTrait;

  public function transform(Reply $model)
  {
    return [
      'id'                  => $model->id,
      'body'                => $model->body,
      'creator'             => $this->userTrans($model->user),
      'vote_count'          => $model->vote_count,
      'is_voted'            => $model->is_voted,
      'updated_at'          => $this->carbonTrans($model->updated_at),
      'created_at'          => $this->carbonTrans($model->created_at),
    ];
  }
}