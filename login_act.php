<?php
session_start();  // セッション開始

//POST値を受け取る
$lid = $_POST['lid'];
$password = $_POST['password'];

// 関数群の呼び出し
require_once('funcs.php');
require_once('db_conn.php');

//1.  DB接続
$pdo = db_conn();

//2. データ登録SQL作成
// kadai10_user_tableにlidとllife_flg=1のユーザーがいるか確認
$stmt = $pdo->prepare("SELECT * FROM kadai10_user_table WHERE lid=:lid AND life_flg=1");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if ($status === false) {
    sql_error($stmt);
}

//4. 抽出データ数を取得
$val = $stmt->fetch();

// フォームから送られたpasswordとハッシュ化されたpasswordを照合
$pw = password_verify($password, $val["password"]);
if ($pw) {
    //Login成功時
    $_SESSION["chk_ssid"]  = session_id();
    $_SESSION["lid"]  = $val['lid'];
    $_SESSION['username'] = $val['username'];
    $_SESSION["kanri"] = $val['kanri_flg']; // 管理者フラグをセッションに保存
    //Login成功時（index.phpへ）
    redirect("index.php");
} else {
    //Login失敗時(login.phpへ)
    redirect("login.php");
}

exit();
