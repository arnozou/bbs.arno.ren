<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model {

  use SoftDeletes;

  protected $fillable = ['category_id', 'title', 'body', 'body_original'];

  protected $dates = ['deleted_at'];
  // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function userInfo()
  {
    return $this->belongsTo(UserInfo::class, 'user_id', 'user_id');
  }
  public function votes()
  {
    return $this->morphMany('App\Vote', 'votable');
  }

  public function lastReply()
  {
    return $this->hasOne(Reply::class, 'topic_id', 'id')->orderBy('created_at', 'desc');
  }

  public function replies()
  {
    return $this->hasMany(Reply::class, 'topic_id', 'id');
  }
}