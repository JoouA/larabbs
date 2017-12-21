<?php
/**
 * Created by PhpStorm.
 * User: 24922
 * Date: 2017/12/20
 * Time: 19:40
 */

namespace App\Models\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;

trait LastActivedAtHelper
{
    // 缓存相关
    protected $hash_prefix = 'larabbs_last_actived_at_';
    protected $field_prefix = 'user_';

    public function recordLastActivedAt()
    {

        //redis 哈希表的命名，如larabbs_last_actived_at_2017-12-20
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称，如：user_1
        $field = $this->getHashField();

        // 当前时间，如：2017-10-21 08:35:15
        $now = Carbon::now()->toDateTimeString();


        // 数据写入 Redis ，字段已存在会被更新
        Redis::hset($hash,$field,$now);
    }

    public function syncUserActivedAt()
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
//        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());
        $hash = $this->getHashFromDateString(Carbon::now()->subDay()->toDateString());

        // 从 Redis 中获取所有哈希表里的数据  获得的数据类型是数组
        /*
          "user_1" => "2017-12-21 15:49:46"
          "user_2" => "2017-12-21 15:49:53"
          "user_3" => "2017-12-21 15:51:10"
        */
        $dates  = Redis::hGetAll($hash);

        // 遍历，并同步到数据库中
        foreach ($dates as $user_id =>  $actived_at){
            // 会将 `user_1` 转换为 1
            $user_id = str_replace($this->field_prefix,'',$user_id);

            // 只有当前用户存在才更新到数据库中
            if ( $user = $this->find($user_id)){
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        Redis::del($hash);

    }

    public function getLastActivedAtAttribute($value)
    {
        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        // 字段名称
        $field = $this->getHashField();

        //三员运算符
        $datetime = Redis::hGet($hash,$field)? :$value;


        //如果存在返回时间对应的carbon实体
        if ($datetime){
            return new Carbon($datetime);
        }else{
            // 否则使用注册时间
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}