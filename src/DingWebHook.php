<?php

namespace Notify;

class DingWebHook
{
    private $msgtype;

    private $webhook;

    private $ssl;

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

    public function getMsgtype()
    {
        return $this->msgtype;
    }

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

    public function formatData($params)
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

    public function sendText($text, $at = null)
    {
        $this->setMsgtype('text');
        $post_string = $this->formatData(['text' => $text, 'at' => $at]);
        return $this->send($post_string);
    }

    public function sendLink($link)
    {
        $this->setMsgtype('link');
        $post_string = $this->formatData(['link' => $link]);
        return $this->send($post_string);
    }

    public function sendMarkdown($markdown, $at = null)
    {
        $this->setMsgtype('markdown');
        $post_string = $this->formatData(['markdown' => $markdown, 'at' => $at]);
        return $this->send($post_string);
    }

    public function sendActionCard($actionCard)
    {
        $this->setMsgtype('actionCard');
        $post_string = $this->formatData(['actionCard' => $actionCard]);
        return $this->send($post_string);
    }

    public function sendFeedCard($feedCard)
    {
        $this->setMsgtype('feedCard');
        $post_string = $this->formatData(['feedCard' => $feedCard]);
        return $this->send($post_string);
    }
}