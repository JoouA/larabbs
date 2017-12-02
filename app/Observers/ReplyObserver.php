<?php

namespace App\Observers;

use App\Models\Reply;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        //
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function saving(Reply $reply)
    {
        //在存储的时候过滤掉xss攻击
        $reply->content = clean($reply->content,'user_topic_body');
    }

    public function saved(Reply $reply)
    {
        $reply->topic()->increment('reply_count',1);
    }
}