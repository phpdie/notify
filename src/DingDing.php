<?php

namespace Notify;

class DingDing
{
    private $msgtype = 'empty';

    private $webhook = '';

    private $ssl = true;

    private $isAtAll = false;

    private $atMobiles = [];

    private $atUserIds = [];

    public function __construct($webhook = '', $ssl = true, $msgtype = 'empty')
    {
        $this->setWebhook($webhook);
        $this->setMsgtype($msgtype);
        $this->setSsl($ssl);
    }

    public function setIsAtAll($isAtAll = false)
    {
        $this->isAtAll = $isAtAll;
        return $this;
    }

    public function setAtMobiles($atMobiles = [])
    {
        $this->atMobiles = $atMobiles;
        return $this;
    }

    public function setAtUserIds($atUserIds = [])
    {
        $this->atUserIds = $atUserIds;
        return $this;
    }

    public function setMsgtype($msgtype = 'empty')
    {
        $this->msgtype = $msgtype;
        return $this;
    }

    public function setWebhook($webhook = '')
    {
        $this->webhook = $webhook;
        return $this;
    }

    public function setSsl($ssl = false)
    {
        $this->ssl = $ssl;
        return $this;
    }

    public function send($post_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->webhook);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json;charset=utf-8']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        if ($this->ssl === false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        }
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    private function formatData($params = [])
    {
        $data = [];
        foreach ($params as $key => $val) {
            if ($val) {
                $data[$key] = $val;
            }
        }
        $data['msgtype'] = $this->msgtype;
        return json_encode($data);
    }

    private function formatAt()
    {
        $at = [];
        foreach (['isAtAll', 'atMobiles', 'atUserIds'] as $val) {
            if ($this->{$val}) {
                $at[$val] = $this->{$val};
            }
        }
        return $at;
    }

    /** 文本text类型
     * @param $text
     * @return bool|string
     */
    public function sendText($text)
    {
        $this->setMsgtype('text');
        $post_string = $this->formatData([
            'text' => [
                'content' => $text
            ],
            'at' => $this->formatAt()
        ]);
        return $this->send($post_string);
    }

    /** 链接Link类型
     * @param $title
     * @param $text
     * @param $messageUrl
     * @param $picUrl
     * @return bool|string
     */
    public function sendLink($title, $text, $messageUrl, $picUrl = '')
    {
        $this->setMsgtype('link');
        $post_string = $this->formatData([
            'link' => [
                'title' => $title,
                'text' => $text,
                'messageUrl' => $messageUrl,
                'picUrl' => $picUrl
            ]
        ]);
        return $this->send($post_string);
    }

    /** Markdown类型
     * @param $title
     * @param $text
     * @return bool|string
     */
    public function sendMarkdown($title, $text)
    {
        $this->setMsgtype('markdown');
        $post_string = $this->formatData([
            'markdown' => [
                'title' => $title,
                'text' => $text
            ],
            'at' => $this->formatAt()
        ]);
        return $this->send($post_string);
    }

    /** 整体跳转ActionCard类型
     * @param $title
     * @param $text
     * @param $singleTitle
     * @param $singleURL
     * @return bool|string
     */
    public function sendActionCardSingle($title, $text, $singleTitle, $singleURL)
    {
        $this->setMsgtype('actionCard');
        $post_string = $this->formatData([
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL
            ]
        ]);
        return $this->send($post_string);
    }

    /** 独立跳转ActionCard类型
     * @param $title
     * @param $text
     * @param $btnOrientation 按钮排列顺序0：按钮竖直排列1：按钮横向排列
     * @param $btns [{"title": "内容不错","actionURL": "https://www.dingtalk.com/"},...]
     * @return bool|string
     */
    public function sendActionCardMulti($title, $text, $btnOrientation, $btns)
    {
        $this->setMsgtype('actionCard');
        $post_string = $this->formatData([
            'actionCard' => [
                'title' => $title,
                'text' => $text,
                'btnOrientation' => $btnOrientation,
                'btns' => $btns
            ]
        ]);
        return $this->send($post_string);
    }

    /** FeedCard类型
     * @param $feedCard [{"title": "时代的火车向前开1","messageURL": "https://www.dingtalk.com/","picURL": "https://img.alicdn.com/a.png"},...]
     * @return bool|string
     */
    public function sendFeedCard($feedCard)
    {
        $this->setMsgtype('feedCard');
        $post_string = $this->formatData([
            'feedCard' => [
                'links' => $feedCard
            ]
        ]);
        return $this->send($post_string);
    }

    public function sendEmpty()
    {
        $this->setMsgtype('empty');
        $post_string = $this->formatData();
        return $this->send($post_string);
    }
}