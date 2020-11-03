<?php

include_once('./_common.php');

class MailAPI_NCloud
{
    private $access_key = "zPEk4sjPxhZdOIGqdWyj";
    private $secret_key = "0IkzZ5HIZGvtCbt49SRHBTSGNKXq4k86DFwGkEHf";

    // mailer($config['cf_admin_email_name'], $config['cf_admin_email'], $mb['mb_email'], $subject, $content, 1);
    // 받는 사람, 메일 내용, HTML 여부.
    // public function sendMail()
    public function sendMail($recipient, $title, $content)
    {
        $message = "POST";
        $message .= " ";
        $message .= "/api/v1/mails";
        $message .= "\n";
        $message .= $this->getTimeStamp();
        $message .= "\n";
        $message .= $this->access_key;
        $signature = base64_encode(hash_hmac('sha256', $message, $this->secret_key, true));

        //

        $headers = array(
            "Content-Type: application/json;",
            "x-ncp-apigw-timestamp: " . $this->getTimeStamp() . "",
            "x-ncp-iam-access-key: " . $this->access_key . "",
            "x-ncp-apigw-signature-v2: " . $signature . ""
        );

        $mailContentsDataSet["senderAddress"] = "allvoice@allvoice.kr";
        $mailContentsDataSet["senderName"] = "올보이스";
        $mailContentsDataSet["title"] = $title;
        $mailContentsDataSet["body"] = stripslashes(htmlspecialchars_decode($content));
        $mailContentsDataSet["recipients"][] = array("address" => $recipient, "type" => "R");
        // $mailContentsDataSet["recipients"][] = array("address" => "참조 이메일", "name" => "참조 이름", "type" => "C");

        if (function_exists('curl_init')) {

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://mail.apigw.ntruss.com/api/v1/mails");
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($mailContentsDataSet));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);

            // json 확인해서 error 있는지 확인...
        }
    }

    private function getTimeStamp()
    {
        list($microtime, $timestamp) = explode(' ', microtime());
        $time = $timestamp . substr($microtime, 2, 3);

        return $time;
    }
}