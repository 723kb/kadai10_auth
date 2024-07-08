<?php
//共通に使う関数を記述
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

//リダイレクト関数: redirect($file_name)
function redirect($file_name)
{
    header('Location: ' . $file_name);
    exit();
}

// ファイルアップロード関数
function handleFileUpload($fileFieldName)
{
    if (isset($_FILES[$fileFieldName]) && $_FILES[$fileFieldName]['error'] === UPLOAD_ERR_OK) {
        return file_get_contents($_FILES[$fileFieldName]['tmp_name']);
    } elseif ($_FILES[$fileFieldName]['error'] !== UPLOAD_ERR_NO_FILE) {
        exit('写真のアップロードに失敗しました');
    }
    return null;
}

//SQLエラー
function sql_error($stmt)
{
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit('SQLError:' . $error[2]);
}

// ログインチェク処理 loginCheck()
// 以下、セッションID持ってたら、ok
// 持ってなければ、閲覧できない処理にする。
// セッションID持っていない or 持っててもサーバーの値と違う場合
function loginCheck()
{
    if (!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] !== session_id()) {
        exit('LOGIN ERROR');
    }
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
}