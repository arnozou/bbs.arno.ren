<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reply extends Model {

  use SoftDeletes;

  protected $fillable = ['user_id', 'topic_id', 'body', 'body_original'];

  protected $dates = ['deleted_at'];
  // protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }

  public function topic()
  {
    return $this->belongsTo(Topic::class, 'topic_id', 'id');
  }

  public function votes()
  {
    return $this->morphMany('App\Vote', 'votable');
  }

  public function getIsVotedAttribute($value)
  {
    return $value;
  }

  public function setIsVotedAttribute($value)
  {
    $this->attributes['is_voted'] = is_bool($value) ? $value : null;
    // $this->attributes['is_voted'] = $value === true ? true : false;
  }
}