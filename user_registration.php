<?php
session_start();
require_once('funcs.php');
require_once('db_conn.php');

//1. POSTデータ取得
$username = filter_input( INPUT_POST, "username" );
$email    = filter_input( INPUT_POST, "email" );
$password = filter_input( INPUT_POST, "password" );
$password = password_hash($password, PASSWORD_DEFAULT);   //パスワードハッシュ化

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO kadai10_user_table(username,email,password,life_flg)VALUES(:username,:email,:password,0)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':email', $email, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':password', $password, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("login.php");
}