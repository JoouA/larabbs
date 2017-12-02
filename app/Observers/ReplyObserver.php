<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

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
        $topic = $reply->topic;
        $topic->increment('reply_count',1);

        // 如果评论的作者不是话题的作者，才需要通知
        if ( ! $reply->user->isAuthorOf($topic)){
            $topic->user->notify(new TopicReplied($reply));
        }

    }
}