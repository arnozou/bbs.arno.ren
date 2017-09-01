<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TopicInterface;
use App\Transformers\TopicTransformer;
use Bouncer;

class TopicController extends ApiController
{
  public function __construct(TopicInterface $topicRepository)
  {
    $this->topicR = $topicRepository;
  }

  public function index(Request $request)
  {
    $inputs = $request->intersect(['before', 'after', 'pageSize']);
    // 验证
    $pageSize = $request->input('pageSize', 5);
    $where = [];
    if ($request->has('after')) {
      $where[] = ['updated_at', '>', $request->input('after')];
    }
    if ($request->has('before')) {
      $where[] = ['updated_at', '<', $request->input('before')];
      if (!$request->has('after')) {
        $this->topicR->orderBy('updated_at', 'desc');
      }
    }
    $topics = $this->topicR->with('user.info')->limit($pageSize)->findWhere($where);

    return $this->response->collection($topics, new TopicTransformer());
  }

  public function store(Request $request)
  {
    $datas = $request->only(['title', 'body', 'category_id']);
    $this->topicR->validate($datas);
    $this->topicR->filterString($datas['title']);
    $this->topicR->fillUser($this->auth->user()->id);
    $topic = $this->topicR->create($datas);

    if ($topic) {
      return $this->response->created(null, ['url' => action('TopicController@show', ['id' => $topic->id])]);
    } else {
      return $this->response->errorInternal();
    }
  }

  public function show(Request $request, $id)
  {
    $topic = $this->topicR->find($id);

    if ($topic) {
      $topic->load('user.info');
      return $this->response->item($topic, new TopicTransformer());
    } else {
      return $this->response->errorBadRequest();
    }
  }

  public function update(Request $request, $topicId)
  {
    $datas = $request->only(['title', 'body']);
    $this->topicR->validate($datas);
    $this->topicR->filterString($datas['title']);
    $topic = $this->topicR->find($topicId);

    if (\Gate::allows('edit-topic', $topic)) {
      // $this->topicR->resetModel($topic);
      $this->topicR->update($datas, $topicId);

      return $this->response->accepted(null, ['url' => action('TopicController@show', ['id' => $topicId])]);
    } else {
      return $this->response->errorForbidden();
    }
  }

  public function vote(Request $request, $topicId)
  {
    if ($res = $this->topicR->vote($topicId, $this->user()->id)) {
      return $this->response->accepted(null, $res);
    } else {
      return $this->response->errorForbidden();
    }
  }

  public function unvote(Request $request, $topicId)
  {
    if ($res = $this->topicR->unvote($topicId, $this->user()->id)) {
      return $this->response->accepted(null, $res);
    } else {
      return $this->response->errorForbidden();
    }
  }

}
