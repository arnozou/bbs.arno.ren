<?php
namespace App\Repositories\Traits;

trait DingoValidateTrait {
  public function validate($datas, $rules)
  {
    $validator = app('validator')->make($datas, $rules);

    if ($validator->fails()) {
      throw new \Dingo\Api\Exception\ResourceException($validator->fails());
    }
  }
}