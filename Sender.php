require_once "Mail.php";

$from = '<fromaddress@gmail.com>';
$to = '<https://r00tsam.github.io/si_samindex.github.io/>';
$subject = 'Hi!';
$body = "Hi,\n\nHow are you?";

$headers = array(
    'From' => $from,
    'To' => $to,
    'Subject' => $subject
);

$smtp = Mail::factory('smtp', array(
        'host' => 'ssl://smtp.gmail.com',
        'port' => '465',
        'auth' => true,
        'username' => 'sardhost62@gmail.com',
        'password' => 'pkpk12345'
    ));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
    echo('<p>' . $mail->getMessage() . '</p>');
} else {
    echo('<p>Message successfully sent!</p>');
}

function listMessages($service, $userId) {
  $pageToken = NULL; //ページトークン
  $messages = array(); //メッセージ
  $opt_param = array(); //オプションパラメータ
  do {
    try {
      if ($pageToken) {
        $opt_param['pageToken'] = $pageToken; //ページトークンをセット
      }
      //メッセージ一覧を取得
      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
      if ($messagesResponse->getMessages()) {
        //マージする
        $messages = array_merge($messages, $messagesResponse->getMessages());
        //ページトークン取得
        $pageToken = $messagesResponse->getNextPageToken();
      }
    } catch (Exception $e) {
      print 'An error occurred: ' . $e->getMessage();
    }
  } while ($pageToken);
  //メッセージを返却
  return $messages;
}