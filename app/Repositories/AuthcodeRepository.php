<?php namespace App\Repositories;

use App\Repositories\Interfaces\AuthcodeInterface;
use App\Authcode;
class AuthcodeRepository implements AuthcodeInterface {

  public function getRecords($mobile, $ip, $timeLengthBefore)
  {
    $where = [
      ['created_at', '>', time() - $timeLengthBefore],
      ['mobile', $mobile],
      ['ip', ip2long($ip)]
     ];

    return Authcode::where($where)->orderBy('id', 'desc')->get();
  }

  public function newRecord($mobile, $ip, $expireTime, $code)
  {
    $authcode = new Authcode();
    $authcode->mobile = $mobile;
    $authcode->ip = $ip;
    $authcode->code = $code;
    $authcode->expire_at = time() + $expireTime;

    return $authcode->save();
  }
 
  public function checkCode($mobile, $code)
  {
    $authcode = Authcode::where('mobile', $mobile)
      ->where('code', $code)
      ->where('is_used', 0)
      ->first();

    if ($authcode) {
      $authcode->is_used = 1;
      $authcode->save();

      return true;
    } else {
      return false;
    }

  }
}