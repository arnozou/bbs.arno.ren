<?php
namespace App\Transformers;

use App\Reply;

class ReplyTransformer extends BaseTransformer {

  use Traits\UserTrait;

  public function transform(Reply $model)
  {//dump($model->relationLoaded('userInfo'));
    return [
      'id'                  => $model->id,
      'body'                => $model->body,
      'creator'             => ($model->relationLoaded('user') || $model->relationLoaded('userInfo'))
      ? $this->userTrans($model->user) : null,
      'vote_count'          => $model->vote_count,
      'is_voted'            => $model->is_voted,
      'updated_at'          => $this->carbonTrans($model->updated_at),
      'created_at'          => $this->carbonTrans($model->created_at),
    ];
  }
}