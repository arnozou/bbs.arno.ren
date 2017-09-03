<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\TopicInterface;
use App\Transformers\TopicTransformer;
use Bouncer;

class TopicController extends ApiController
{

  use Traits\DingoValidateTrait;

  public function __construct(TopicInterface $topicRepository)
  {
    $this->topicR = $topicRepository;
  }

  public function index(Request $request, $categoryId = 0)
  {
    $categoryId = $request->input('category_id', $categoryId);
    if ((int)$categoryId === 0) {
      return $this->response->noContent();
    }
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
    $where[] = ['category_id', '=', $categoryId];
    $topics = $this->topicR->with('user.info')->limit($pageSize)->findWhere($where);

    return $this->response->collection($topics, new TopicTransformer());
  }

  public function store(Request $request, $categoryId = 0)
  {
    $datas = $request->only(['title', 'body']);
    $datas['category_id'] = $request->input('category_id', $categoryId);
    $this->topicR->validate($datas);
    $this->validate($datas, [
      'title'       => 'required|string|max:255',
      'body'        => 'required',
      'category_id' => 'required|integer|min:1'
      ]);
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
