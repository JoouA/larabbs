<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;
use App\Models\User;
use App\Models\Topic;

class ReplysTableSeeder extends Seeder
{
    public function run()
    {
        // 所有用户的id数组
        $user_ids =  User::all()->pluck('id')->toArray();

        //所有话题的id数组
        $topic_ids = Topic::all()->pluck('id')->toArray();

        //获取faker实例
        $faker = app(\Faker\Generator::class);


        $replys = factory(Reply::class)->times(1000)->make()->each(function ($reply, $index) use ($user_ids,$topic_ids,$faker) {
            //从用户ID数组随机去除一个并且赋值
            $reply->user_id = $faker->randomElement($user_ids);

            //话题同上
            $reply->topic_id = $faker->randomElement($topic_ids);
        });

        // 将数据集合转换成数组，并且插入到数据库中
        Reply::insert($replys->toArray());
    }

}

