<?php
namespace App\Transformers;

use App\Topic;

class TopicTransformer extends BaseTransformer {

  use Traits\UserTrait;

  public function transform(Topic $model)
  {
    $replyTransformer = new ReplyTransformer();
    return [
      'id'                  => $model->id,
      'category_id'         => $model->category_id,
      'title'               => $model->title,
      'body'                => $model->body,
      'creator'             => $this->userTrans($model->user),
      'reply_count'         => $model->reply_count,
      'vote_count'          => $model->vote_count,
      'read_count'          => $model->read_count,
      'last_reply_user_id'  => $model->last_reply_user_id,
      'last_reply'          => $model->relationLoaded('lastReply') ? $model->lastReply ?
       $replyTransformer->transform($model->lastReply) : null : null,
      'created_at'          => $this->carbonTrans($model->created_at),
      'created_humans'      => $this->diffForHumans($model->created_at),
      'updated_at'          => $this->carbonTrans($model->updated_at),
      'updated_humans'      => $this->diffForHumans($model->updated_at),
    ];
  }
}