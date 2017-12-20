<?php
namespace App\Observers;

use App\Models\Link;
use Cache;

class LinkObserver
{

    // creating, created, updating, updated, saving,
    // saved,  deleting, deleted, restoring, restored

    // 在保持时清空 cache_key 对应的缓存
    public function saved(Link $link)
    {
        //之前之所以无法删除是因为，cache_key，设置成了protected，所以无法获取到cache_key这个值，也就无法删除缓存了

        Cache::forget($link->cache_key);
    }

    public function deleted(Link $link)
    {
        Cache::forget($link->cache_key);
    }

    public function updated(Link $link)
    {
        Cache::forget($link->cache_key);
    }

}