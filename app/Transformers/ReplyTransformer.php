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
      'creater'             => $this->userTrans($model->user),
      'vote_count'          => $model->vote_count,
      'updated_at'          => $model->updated_at,
    ];
  }
}