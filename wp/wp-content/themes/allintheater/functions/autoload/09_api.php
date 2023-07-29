<?php

add_action('rest_api_init', function() {
    // register a endpoint
    // send email
    register_rest_route( '/api', '/inquiry', [
        'methods' => 'POST',
        //エンドポイントにアクセスした際に実行される関数
        'callback' => 'send_inquiry_email',
    ]);

    register_rest_route( '/api', '/test', [
      'methods' => 'get',
      //エンドポイントにアクセスした際に実行される関数
      'callback' => 'test',
  ]);
});

function test() {
  $response = new WP_REST_Response(['aaa' => 'bbb']);
  $response->set_status(200);
  return $response;
}

function send_inquiry_email(WP_REST_Request $request) {

  //言語と文字コードを設定
  mb_language("Japanese"); 
  mb_internal_encoding("UTF-8");

  $data = $request->get_json_params();

  $company_name = $data['company_name'];
  $inquiry_item = $data['inquiry_item'];
  $name = $data['name'];
  $email = $data['email'];
  $inquiry = $data['inquiry'];

  $signature = SIGNATURE;

  $subject = '【株式会社allintheater】お問い合せありがとうございます。';
  $to = $email;

  $message = <<<EOM
*このメールはシステムからの自動返信です。

株式会社allintheaterへのお問い合せありがとうございました。
以下の内容でお問い合せを受け付け致しました。

担当者からご連絡致しますので、今しばらくお待ちください。


会社名: $company_name
お問い合わせ項目: $inquiry_item
氏名: $name
メールアドレス: $email
お問い合わせ内容: $inquiry

$signature
EOM;

  // send Email
  $r = wp_mail( $to, $subject, $message );
  // $r = wp_mail( $to, $subject, 'test mail' );

  $admin_message = <<<EOM
お問い合せを受信しました。

以下内容でお問い合わせがありましたので、対応お願いします。


会社名: $company_name
お問い合わせ項目: $inquiry_item
氏名: $name
メールアドレス: $email
お問い合わせ内容: $inquiry

EOM;

  // send Email
  $r = wp_mail( "contact@allintheater.co.jp", "【株式会社allintheater】お問い合せを受信しました。", $admin_message );

  $response = new WP_REST_Response();
  $response->set_status(200);
  return $response;
}