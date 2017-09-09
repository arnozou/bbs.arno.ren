<?php 
namespace App\Transformers\Traits;

use App\User;
use App\UserInfo;
trait UserTrait {

  protected function userTrans($model)
  {
    if ($model instanceof User) {
      return $this->userAndInfoTrans($model);
    } else if ($model instanceof UserInfo) {
      return $this->userInfoTrans($model);
    }

    throw new \Exception('class User or UserInfo required');
  }

  protected function userAndInfoTrans(User $model)
  {
    return [
      'id'            => $model->id,
      'nick_name'     => $model->info->nick_name,
      'avatar_url'    => $model->info->avatar_url,
      'intro'         => $model->info->intro
    ];
  }

  protected function userInfoTrans(UserInfo $model)
  {
    return [
      'id'            => $model->user_id,
      'nick_name'     => $model->nick_name,
      'avatar_url'    => $model->avatar_url,
      'intro'         => $model->intro
    ];
  }
}