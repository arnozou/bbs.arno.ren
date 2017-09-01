<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ReplyInterface;
use App\Transformers\ReplyTransformer;
use Validator;
use Topic;
// use Bouncer;

class ReplyController extends ApiController
{
  use Traits\DingoValidateTrait;

  public function __construct(ReplyInterface $replyRepository)
  {
    $this->replyR = $replyRepository;
  }

  public function index(Request $request, $topicId)
  {
    $topic = $this->replyR->topicExists($topicId);
    $this->replyR->updatePaginate($request->input('limit', 10),
      $request->input('after'), $request->input('before'));
    $replies = $this->replyR->findByField('topic_id', $topicId);
    
    $replies->load('user.info');
    return $this->response->collection($replies, new ReplyTransformer());
  }

  public function store(Request $request, $topicId)
  {
    $topic = $this->replyR->topicExists($topicId);
    if (!$topic) {
      return $this->response->errorBadRequest();
    }

    $datas['body_original'] = $request->input('body');
    $datas = [
    'topic_id'        => $topicId,
    'user_id'         => $this->user()->id,
    'body_original'   => $request->input('body')
    ];

    $datas['body'] = $this->replyR->parseMarkdown($datas['body_original']);

    $reply = $this->replyR->create($datas);
    if ($reply) {
      $topic->increment('reply_count');
      return $this->response->created();
    } else {
      return $this->response->errorInternal();
    }
  }

  public function edit(Request $request, $replyId)
  {
    
    $reply = $this->replyR->find($replyId);
    if (!$reply) {
      return $this->response->errorBadRequest();
    }

    if ($reply->user_id == $this->auth->user()->id) {
      // 输出原始数据
      $reply->body = $reply->body_original;
      $reply->load('user.info');
      return $this->response->item($reply, new ReplyTransformer());
    } else {
      return $this->response->errorForbidden();
    }
  }

  public function update(Request $request, $replyId)
  {
    $this->validate([
      'body'      => $request->input('body'),
      'reply_id'  => $replyId,
      ], [
      'body'      => 'required',
      'reply_id'  => 'required|integer|exists:replies'
      ]);

    $datas['body_original'] = $request->input('body');
    $datas = [
    'user_id'         => $this->auth->user()->id,
    'body_original'   => $request->input('body')
    ];
    $datas['body'] = $this->replyR->parseMarkdown($datas['body_original']);

    if ($reply->user_id == $this->auth->user()->id) {
      $this->replyR->update();
    }
  }


  public function destory(Request $request, $replyId)
  {
    $reply = $this->replyR->find($replyId);

    if (!$reply) {
      return $this->response->errorBadRequest();
    }

    if ($this->replyR->delete($replyId)) {
      return $this->response->noContent();
    } else {
      return $this->response->errorInternal();
    }
  }

  public function vote($replyId)
  {
    if ($res = $this->replyR->vote($replyId, $this->user()->id)) {
      return $this->response->accepted(null, $res);
    } else {
      return $this->response->errorForbidden();
    }
  }

  public function unvote($replyId)
  {
    if ($this->replyR->unvote($replyId, $this->user()->id)) {
      return $this->response->accepted();
    } else {
      return $this->response->errorForbidden();
    }
  }
}