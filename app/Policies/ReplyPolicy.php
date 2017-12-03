<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;

class ReplyPolicy extends Policy
{
    public function update(User $user, Reply $reply)
    {
        // return $reply->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Reply $reply)
    {
        // 自己的回复或者是这个话题的作者才能删除该回复
        return  $user->isAuthorOf($reply) || $user->isAuthorOf($reply->topic);
    }
}
