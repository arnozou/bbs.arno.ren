<?php namespace App\Repositories\Interfaces;

Interface AuthcodeInterface
{
  public function getRecords($mobile, $ip, $timeLengthBefore);

  public function newRecord($mobile, $ip, $expireTime, $code);

  public function checkCode($mobile, $code);
}