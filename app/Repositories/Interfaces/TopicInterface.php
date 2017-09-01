<?php namespace App\Repositories\Interfaces;

Interface TopicInterface
{
  public function vote($topicId, $userId);

  public function unvote($topicId, $userId);
}