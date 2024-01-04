<?php

namespace Notify;

class DingDing
{
    private $msgtype;

    private $webhook;

    private $ssl;

    private $isAtAll = false;
    private $atMobiles = [];
    private $atUserIds = [];

    public function __construct($webhook = '', $ssl = true, $msgtype = '')
    {
        if ($webhook) {
            $this->setWebhook($webhook);
        }
        if ($msgtype) {
            $this->setMsgtype($msgtype);
        }
        $this->setSsl($ssl);
    }

    public function isAtAll()
    {
        return $this->isAtAll;
    }

    public function setIsAtAll($isAtAll)
    {
        $this->isAtAll = $isAtAll;
        return $this;
    }

    public function getAtMobiles()
    {
        return $this->atMobiles;
    }

    public function setAtMobiles($atMobiles)
    {
        $this->atMobiles = $atMobiles;
        return $this;
    }

    public function getAtUserIds()
    {
        return $this->atUserIds;
    }

    public function setAtUserIds(array $atUserIds)
    {
        $this->atUserIds = $atUserIds;
        return $this;
    }

    public function getMsgtype()
    {
        return $this->msgtype;
    }

    /** https://open.dingtalk.com/document/isvapp/message-type
     * @param $msgtype
     * @return void
     */
    public function setMsgtype($msgtype)
    {
        $this->msgtype = $msgtype;
    }

    public function getWebhook()
    {
        return $this->webhook;
    }

    public function setWebhook($webhook)
    {
        $this->webhook = $webhook;
    }

    public function isSsl()
    {
        return $this->ssl;
    }

    public function setSsl($ssl)
    {
        $this->ssl = $ssl;
    }

    public function send($post_string)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getWebhook());
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // 线下环境不用开启curl证书验证, 未调通情况可尝试添加该代码
        if ($this->isSsl() === false) {
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
        $data['msgtype'] = $this->getMsgtype();
        return json_encode($data);
    }

    private function formatAt()
    {
        $at['isAtAll'] = $this->isAtAll();
        $at['atMobiles'] = $this->getAtMobiles();
        $at['atUserIds'] = $this->getAtUserIds();
        return $at;
    }

    public function sendText($text)
    {
        $this->setMsgtype('text');
        $post_string = $this->formatData(['text' => ['content' => $text], 'at' => $this->formatAt()]);
        return $this->send($post_string);
    }

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

    public function sendMarkdown($title, $text)
    {
        $this->setMsgtype('markdown');
        $post_string = $this->formatData(['markdown' => ['title' => $title, 'text' => $text], 'at' => $this->formatAt()]);
        return $this->send($post_string);
    }

    public function sendActionCard($title, $text, $singleTitle, $singleURL)
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

    public function sendFeedCard($feedCard)
    {
        $this->setMsgtype('feedCard');
        $post_string = $this->formatData(['feedCard' => ['links' => $feedCard]]);
        return $this->send($post_string);
    }

    public function sendEmpty()
    {
        $this->setMsgtype('empty');
        $post_string = $this->formatData();
        return $this->send($post_string);
    }
}