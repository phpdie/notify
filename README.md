```php
require_once __DIR__ . '/vendor/autoload.php';

$client = new \Notify\DingDing('你的机器人webhook地址');

/*
$text = new \stdClass();
$text->content = 'hello靓仔';
$result = $client->sendText($text);
print_r($result);
*/

/*
$link = new \stdClass();
$link->title = '你好靓仔';
$link->text = 'hello靓仔';
$link->picUrl = 'https://www.baidu.com/img/flexible/logo/pc/result.png';
$link->messageUrl = 'https://www.baidu.com/';
$result = $client->sendLink($link);
print_r($result);
*/

/*
$markdown = new \stdClass();
$markdown->title = '杭州天气';
$markdown->text = "#### 杭州天气\n > 9度，西北风1级，空气良89，相对温度73%\n > ![screenshot](https://img.alicdn.com/tfs/TB1NwmBEL9TBuNjy1zbXXXpepXa-2400-1218.png)\n > ###### 10点20分发布 [天气](https://www.dingtalk.com) \n";
$at = new \stdClass();
$at->isAtAll = true;
$result = $client->sendMarkdown($markdown, $at);
print_r($result);
*/

/*
$actionCard = new \stdClass();
$actionCard->title = '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身';
$actionCard->text = "![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
 ### 乔布斯 20 年前想打造的苹果咖啡厅 
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划";
$actionCard->btnOrientation = 0;//0：按钮竖直排列  1：按钮横向排列
$actionCard->singleTitle = "阅读全文";
$actionCard->singleURL = "https://www.dingtalk.com/";
$result = $client->sendActionCard($actionCard);
print_r($result);
*/

/*
$btn1 = new \stdClass();
$btn1->title = '百度1';
$btn1->actionURL = 'https://www.baidu.com';

$btn2 = new \stdClass();
$btn2->title = '百度2';
$btn2->actionURL = 'https://www.baidu.com';

$actionCard = new \stdClass();
$actionCard->title = '乔布斯 20 年前想打造一间苹果咖啡厅，而它正是 Apple Store 的前身';
$actionCard->text = "![screenshot](https://gw.alicdn.com/tfs/TB1ut3xxbsrBKNjSZFpXXcXhFXa-846-786.png) 
 ### 乔布斯 20 年前想打造的苹果咖啡厅 
 Apple Store 的设计正从原来满满的科技感走向生活化，而其生活化的走向其实可以追溯到 20 年前苹果一个建立咖啡馆的计划";
$actionCard->btnOrientation = 1;//0：按钮竖直排列  1：按钮横向排列
$actionCard->btns = [$btn1, $btn2];
$result = $client->sendActionCard($actionCard);
$result = $client->sendActionCard($actionCard);
print_r($result);
*/

/*
$link1 = new \stdClass();
$link1->title = '百度1';
$link1->messageURL = 'https://www.baidu.com';
$link1->picURL = 'https://www.baidu.com/img/flexible/logo/pc/result.png';

$link2 = new \stdClass();
$link2->title = '百度2';
$link1->messageURL = 'https://www.baidu.com';
$link1->picURL = 'https://www.baidu.com/img/flexible/logo/pc/result.png';
$feedCard = new \stdClass();
$feedCard->links = [$link1, $link2];
$result = $client->sendFeedCard($feedCard);
print_r($result);
*/
