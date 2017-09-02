<?php
namespace App\Http\Controllers\Traits;

trait DingoValidateTrait {
  public function validate($datas, $rules)
  {
    $validator = app('validator')->make($datas, $rules);

    if ($validator->fails()) {
      throw new \Dingo\Api\Exception\ValidationHttpException($validator->errors());
      // throw new \Dingo\Api\Exception\ResourceException($validator->errors());
    }
  }
}