<?php 
namespace App\Transformers\Traits;

use App\User;
trait UserTrait {

  protected function userTrans(User $model)
  {
    return [
      'id'            => $model->id,
      'nick_name'     => $model->info->nick_name,
      'avatar_url'    => $model->info->avatar_url,
      'intro'         => $model->info->intro
    ];
  }
}