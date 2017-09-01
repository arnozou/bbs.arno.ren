<?php namespace App\Repositories\Interfaces;

Interface ReplyInterface
{
  public function vote($replyId, $userId);

  public function unvote($replyId, $userId);
}