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
                        '才貌双全',
                        '乐观',
                        '犀利话唠',
                        '高冷范',
                        '学霸',
                        '宝藏青年',
                        '文艺范儿',
                        '拖延症',
                        '美食家',
                        '欢乐逗比',
                        '爱面子',
                        '电竞高手',
                        '艺术天赋',
                        '佛系青年',
                        '有进取心',
                        '强迫症',
                        '多重人格',
                        '完美主义',
                        '理论大师',
                        '安静'
                    ]
                ],
                [
                    'name' => '资深粉',
                    'items' => [
                        '薛之谦',
                        '鹿晗',
                        '邓伦',
                        '迪丽热巴',
                        '张艺兴',
                        '杨洋',
                        '蔡徐坤',
                        '五月天',
                        '刘亦菲',
                        '胡歌',
                        '张云雷',
                        '王源',
                        '王俊凯',
                        '李现',
                        '易烊千玺',
                        '周杰伦',
                        '朱一龙',
                        '王一博',
                        '肖战'
                    ]
                ],
                [
                    'name' => '游戏',
                    'items' => [
                        '逆水寒',
                        'apex',
                        'csgo',
                        '守望先锋',
                        '阴阳师',
                        '崩坏3',
                        '狼人杀',
                        '桌游',
                        '自走棋',
                        '第五人格',
                        '剑三',
                        'Dota2',
                        '闪耀暖暖',
                        '魔兽世界',
                        '我的世界',
                        '和平精英',
                        '绝地求生',
                        'steam',
                        '王者荣耀',
                        '英雄联盟'
                    ]
                ],
                [
                    'name' => '二次元',
                    'items' => [
                        '腐女',
                        '绅士',
                        '萌妹',
                        '腐宅',
                        '番剧',
                        'fate',
                        'FGO',
                        'Lolita',
                        '配音',
                        '哆啦A梦',
                        '银魂',
                        '夏目友人帐',
                        '中二病晚期',
                        '火影忍者',
                        '魔道祖师动画',
                        '漫威',
                        '国漫',
                        '宫崎骏',
                        '名侦探柯南',
                        '海贼王'
                    ]
                ],
                [
                    'name' => '吃吃吃',
                    'items' => [
                        '酸菜鱼',
                        '甜食控',
                        '素食主义',
                        '肉食主义',
                        '水果',
                        '马卡龙',
                        '日料',
                        '甜甜圈',
                        '无辣不欢',
                        '麻辣烫',
                        '鸡排',
                        '泡面',
                        '可乐',
                        '咖啡',
                        '炸鸡',
                        '零食',
                        '烧烤',
                        '螺狮粉',
                        '火锅',
                        '奶茶'
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
                $insertCategory['name'] = $name;
            });

            \ZYProSoft\Log\Log::info('category will insert:'.json_encode($insertCategory));
            Db::table('hobby_category')->insertOrIgnore($insertCategory);

            $categoryList = \App\Model\HobbyCategory::all()->keyBy('name');

            \ZYProSoft\Log\Log::info('categoryList by name:'.json_encode($categoryList));

            $batchHobbyItems = [];
            $hobby->map(function (array $item) use ($categoryList){
                \ZYProSoft\Log\Log::info('item :'.json_encode($categoryList[$item['name']]));
               $categoryId = $categoryList[$item['name']];
               $items = collect($item['items']);
               $items->map(function (string $subItem) use ($categoryId){
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
