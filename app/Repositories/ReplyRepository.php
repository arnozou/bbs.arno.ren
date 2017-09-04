<?php namespace App\Repositories;

use App\Repositories\Interfaces\ReplyInterface;
use App\Vote;
use Illuminate\Database\Eloquent\Collection;

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
      $vote = Vote::where('votable_type', 'reply')->where('votable_id', $replyId)->where('user_id', $userId)->first();
      if ($vote) {
        if (!$vote->vote_type) {
          $vote->vote_type = 1;
          $vote->save();
          $model->increment('vote_count');
          return ['vote_count' => $model->vote_count];
        }
      } else {
        $vote = Vote::create([
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
      $vote = Vote::where('votable_type', 'reply')->where('votable_id', $replyId)->where('user_id', $userId)->first();
      if ($vote && $vote->vote_type) {
        $vote->vote_type = 0;
        $vote->save();
        $model->decrement('vote_count');
        return ['vote_count' => $model->vote_count];
      }
    }

    return false;
  }

  public function areVotedBy(Collection $replies, $userId)
  {
    $ids = [];
    foreach ($replies as $reply) {
      $ids[] = $reply->id;
    }

    $votes = Vote::where('user_id', '=', $userId)
      // ->join('votes', 'replies.id', '=', 'votes.votable_id');
      ->whereIn('votable_id', $ids)
      ->where('votable_type', '=', 'reply')
      ->get();

    $voteData = [null];
    foreach ($votes as $vote) {
      $voteData[] = $vote->votable_id;
    }

    foreach ($replies as $reply) {
      if(array_search($reply->id, $voteData)) {
        $reply->is_voted = true;
      } else {
        $reply->is_voted = false;
      }
    }

    return $replies;
  }
}