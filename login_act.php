<?php
session_start();

//POST値を受け取る
$username = $_POST['username'];
$password = $_POST['password'];

//1.  DB接続します
require_once('funcs.php');
require_once('db_conn.php');
$pdo = db_conn();

//2. データ登録SQL作成
// kadai10_user_tableに、usernameとpasswordがあるか確認する。
$stmt = $pdo->prepare("SELECT * FROM kadai10_user_table WHERE username=:username AND life_flg=1");
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if ($status === false) {
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

$pw = password_verify($password, $val["password"]);
if ($pw) {
    //Login成功時
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["username"]  = $val['username'];
    $_SESSION["kanri"] = $val['kanri_flg']; // 管理者フラグをセッションに保存
    //Login成功時（index.phpへ）
    redirect("index.php");
} else {
    //Login失敗時(login.phpへ)
    redirect("login.php");
}

exit();
