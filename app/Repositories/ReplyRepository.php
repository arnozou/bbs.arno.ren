<?php namespace App\Repositories;

use App\Repositories\Interfaces\ReplyInterface;


class ReplyRepository extends Repository implements ReplyInterface {

  use Traits\MarkdownTrait;
  use Traits\UpdatePaginateTrait;

  public function model()
  {
    return '\App\Reply';
  }

  public function rules()
  {
    return [];
  }

  public function topicExists($topicId)
  {
    $topic = \App\Topic::find($topicId);

    if ($topic) {
      return $topic;
    }

    return false;
  }

  public function vote($replyId, $userId)
  {
    $model = $this->model->find($replyId);
    if ($model) {
      $vote = \App\Vote::where('votable_type', 'reply')->where('votable_id', $replyId)->where('user_id', $userId)->first();
      if ($vote) {
        if (!$vote->vote_type) {
          $vote->vote_type = 1;
          $vote->save();
          $model->increment('vote_count');
          return ['vote_count' => $model->vote_count];
        }
      } else {
        $vote = \App\Vote::create([
          'user_id'      => $userId,
          'votable_type' => 'reply',
          'votable_id'   => $replyId,
          'vote_type'    => 1,
          ]);
        if ($vote) {
          $model->increment('vote_count');
          return ['vote_count' => $model->vote_count];
        }
      }
    }

    return false;
  }

  public function unvote($replyId, $userId)
  {
    $model = $this->model->find($replyId);
    if ($model) {
      $vote = \App\Vote::where('votable_type', 'reply')->where('votable_id', $replyId)->where('user_id', $userId)->first();
      if ($vote && $vote->vote_type) {
        $vote->vote_type = 0;
        $vote->save();
        $model->decrement('vote_count');
        return ['vote_count' => $model->vote_count];
      }
    }

    return false;
  }
}