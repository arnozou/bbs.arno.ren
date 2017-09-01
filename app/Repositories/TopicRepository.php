<?php namespace App\Repositories;

use App\Repositories\Interfaces\TopicInterface;


class TopicRepository extends Repository implements TopicInterface {

  use Traits\MarkdownTrait;
  use Traits\StringInputTrait;

  public function model()
  {
    return 'App\Topic';
  }

  public function rules()
  {
    return [
    'title' => 'required|max:255',
    'body'  => 'required'
    ];
  }

  public function create(array $datas)
  {
    if (!$this->model->user_id) {
      throw new \Exception('must fill user_id before create');
    }
    $this->fillMarkdown($datas);
    $model = $this->model;
    $model->fill($datas)->save();
    $this->resetModel();

    return $model;
  }

  public function update(array $datas, $id)
  {
    $this->fillMarkdown($datas);
    $model = $this->model->find($id);
    $model->fill($datas)->save();
    $this->resetModel();

    return $model;
  }

  public function fillUser($userId)
  {
    $this->model->user_id = $userId;
  }

  public function vote($topicId, $userId)
  {
    $model = $this->model->find($topicId);
    if ($model) {
      $vote = \App\Vote::where('votable_type', 'topic')->where('votable_id', $topicId)->where('user_id', $userId)->first();
      if ($vote) {
        if (!$vote->vote_type) {
          $vote->vote_type = 1;
          $vote->save();
          $model->increment('vote_count');
          return true;
        }
      } else {
        $vote = \App\Vote::create([
          'user_id'      => $userId,
          'votable_type' => 'topic',
          'votable_id'   => $topicId,
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

  public function unvote($topicId, $userId)
  {
    $model = $this->model->find($topicId);
    if ($model) {
      $vote = \App\Vote::where('votable_type', 'topic')->where('votable_id', $topicId)->where('user_id', $userId)->first();
      if ($vote && $vote->vote_type) {
        $vote->vote_type = 0;
        $vote->save();
        $model->decrement('vote_count');
        return ['vote_count' => $model->vote_count];
      }
    }

    return false;
  }

  protected function fillMarkdown(&$datas)
  {
    $datas['body_original'] = $datas['body'];
    $datas['body'] = $this->parseMarkdown($datas['body']);
  }
}