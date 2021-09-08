<?php

declare(strict_types=1);

use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class CreateHobbyInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::transaction(function (){

            $hobby = [
                [
                    'name' => '特征标签',
                    'items' => [
                       '相亲',
                        '交友',
                        '创业',
                        '投资',
                        '音乐发烧友',
                        '运动达人',
                        '阅历',
                        '沉稳',
                        '有故事',
                        '面基',
                        '吉安通',
                        '包打听',
                        '网红'
                    ]
                ],
                [
                    'name' => '读书',
                    'items' => [
                        '漫画',
                        '悬疑',
                        '推理',
                        '网游',
                        '刘慈欣',
                        '金庸',
                        '郭敬明',
                        '韩寒',
                        '江南',
                        '三毛',
                        '琼瑶',
                        '张爱玲',
                        '王小波',
                        '树上春树',
                        '镇魂',
                        '盗墓笔记',
                        '东野圭吾',
                        '哈利波特',
                        '忘羡',
                        '魔道祖师'
                    ]
                ],
                [
                    'name' => '运动',
                    'items' => [
                        '爬山',
                        '攀岩',
                        '长跑',
                        '撸铁',
                        '蹦极',
                        '跳伞',
                        '滑雪',
                        '跆拳道',
                        '排球',
                        '街舞',
                        '游泳',
                        '羽毛球',
                        '乒乓球',
                        '户外',
                        '篮球',
                        '足球',
                        '骑行',
                        '瑜伽',
                        '滑板',
                        '跑步'
                    ]
                ]
            ];

            $hobby = collect($hobby);

            $category = $hobby->pluck('name');
            $insertCategory = [];
            $category->map(function (string $name) use (&$insertCategory){
                $insertCategory[] = ['name'=>$name];
            });

            \ZYProSoft\Log\Log::info('category will insert:'.json_encode($insertCategory));
            Db::table('hobby_category')->insertOrIgnore($insertCategory);

            $categoryList = \App\Model\HobbyCategory::all()->keyBy('name');

            \ZYProSoft\Log\Log::info('categoryList by name:'.json_encode($categoryList));

            $batchHobbyItems = [];
            $hobby->map(function (array $item) use ($categoryList,&$batchHobbyItems){
               $categoryId = $categoryList[$item['name']]->category_id;
               $items = collect($item['items']);
               \ZYProSoft\Log\Log::info("Hobby items:".json_encode($items));
               $items->map(function (string $subItem) use ($categoryId,&$batchHobbyItems){
                  $hobbyItem['category_id'] = $categoryId;
                  $hobbyItem['title'] = $subItem;
                  $batchHobbyItems[] = $hobbyItem;
               });
            });

            \ZYProSoft\Log\Log::info('hobbyItems:'.json_encode($batchHobbyItems));
            Db::table('hobby_label')->insertOrIgnore($batchHobbyItems);
        });
    }
}
