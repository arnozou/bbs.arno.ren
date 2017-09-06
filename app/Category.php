<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

use RedisServer;

class Category extends Model {

  public function children() {
    return $this->hasMany(Category::class, 'parent_id', 'id');
  }

  public function getLastReplyIdAttribute($value)
  {
    return $this->attributes['last_reply_id'];
  }

  public function setLastReplyIdAttribute($replyId)
  {
    return $this->attributes['last_reply_id'] = $replyId;
  }

  public function getLastReplyAttribute($value)
  {
    if ($value instanceof Reply) {
      return $value;
    } else if ($replyId = $this->attributes['last_reply_id']) {
      return Reply::find($replyId);
    }

    return null;
  }

  public function setLastReplyAttribute(Reply $reply)
  {
    $this->last_reply_id = $reply->id;
    return $this->attributes['last_reply'] = $reply;
  }

  public function redisSaveLastReplyId($replyId)
  {
    return RedisServer::hset('category_last_reply_ids', $this->id, $replyId);
  }

  public function redisLoadLastReplyId()
  {
    return RedisServer::hget('category_last_reply_ids', $this->id);
  }
}
