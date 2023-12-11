<?php

add_action('rest_api_init', function() {
    // register a endpoint
    // send email
    register_rest_route( '/api', '/inquiry', [
        'methods' => 'POST',
        //エンドポイントにアクセスした際に実行される関数
        'callback' => 'send_inquiry_email',
        'permission_callback' => '__return_true'
    ]);

    register_rest_route( '/api', '/test', [
      'methods' => 'get',
      //エンドポイントにアクセスした際に実行される関数
      'callback' => 'test',
      'permission_callback' => '__return_true'
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


  $inquiry_type = $data['inquiry_type'];
  $company_name = $data['company_name'];
  $inquiry = $data['inquiry'];
  $name = $data['name'];
  $email = $data['email'];
  $department_name = $data['department_name'];
  $name_kanji = $data['name_kanji'];
  $name_furigana = $data['name_furigana'];
  $inquiry = $data['inquiry'];

  $signature = SIGNATURE;

  $subject = '【Umplex】お問い合わせありがとうございます。';
  $to = $email;

  $message = <<<EOM
Umplexにお問い合わせいただきありがとうございます。

下記の内容でお問い合わせをうけたまわりました。
弊社で内容を確認の上、折り返しご連絡いたしますのでいましばらくお待ち下さい。

-----------------------------------

種別: 
$inquiry_type

会社名・組織名: 
$company_name

部署名・部門名: 
$department_name

氏名(漢字):
$name_kanji

氏名(ふりがな): 
$name_furigana

メールアドレス: 
$email

問い合わせ内容: 
$inquiry

$signature
EOM;

  // send Email
  $r1 = wp_mail( $to, $subject, $message );
  // $r = wp_mail( $to, $subject, 'test mail' );

  $admin_message = <<<EOM
下記の内容で問い合わせがありました。
3営業日中に折り返しの対応をお願いいたします。
  
-----------------------------------

種別: 
$inquiry_type

会社名・組織名: 
$company_name

部署名・部門名: 
$department_name

氏名(漢字):
$name_kanji

氏名(ふりがな): 
$name_furigana

メールアドレス: 
$email

問い合わせ内容: 
$inquiry

EOM;

  // send Email
  $r2 = wp_mail( "info_umplex@allhero.co.jp", "【Umplex】お問い合わせがありました。", $admin_message );

  $response = new WP_REST_Response(["success" => $r2]);
  $response->set_status(200);
  return $response;
}