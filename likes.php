<?php
// エラー表示設定(デバッグ用)→本番環境では表示させない
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();  // セッション開始
require_once('funcs.php');  // 関数群の呼び出し
require_once('db_conn.php');

// セッションデバッグ用
// error_log('Session data in likes.php: ' . print_r($_SESSION, true));

// DB接続
$pdo = db_conn();

// ログインチェック
$is_logged_in = isset($_SESSION['chk_ssid']) && $_SESSION['chk_ssid'] === session_id();
$response = ['success' => false, 'message' => 'エラーが発生しました。'];

// ログインしているかつ投稿IDがPOSTされている(いいねが押されている)場合
if ($is_logged_in && isset($_POST['post_id'])) {
    // POSTされた投稿IDを整数型にして取得 整数型にすることで意図しないクエリ実行を防ぐ＆整合性を保つ
    $post_id = (int)$_POST['post_id'];

    // ユーザーIDをセッションから取得
    if (isset($_SESSION['user_id'])) {
        $user_id = (int)$_SESSION['user_id'];
        // error_log('User ID: ' . $user_id);  // デバッグ用ログ
    } else {
        // ユーザーIDが取得できない場合はエラーレスポンスを返して終了
        echo json_encode(['success' => false, 'message' => 'ユーザーIDが取得できませんでした']);
        exit;
    }

    try {
        // ユーザーがすでにいいねしているかどうかをチェック
        $is_liked = checkUserLike($pdo, $user_id, $post_id);
        // いいねの追加または削除処理
        if ($is_liked) {
            // いいね削除SQL
            $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND post_id = :post_id");
            // error_log('Deleting like for user_id: ' . $user_id . ' and post_id: ' . $post_id);  // デバッグ用ログ
            $is_liked = false;  // いいねが解除された
        } else {
            // いいね追加SQL
            $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (:user_id, :post_id)");
            // error_log('Inserting like for user_id: ' . $user_id . ' and post_id: ' . $post_id);  // デバッグ用ログ
            $is_liked = true;  // いいねが追加された
        }
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $stmt->execute();
        error_log('Query executed successfully');  // デバッグ用ログ

        // 更新後のいいね数を取得
        $like_count = getLikeCount($pdo, $post_id);
        error_log('Like count: ' . $like_count);  // デバッグ用ログ
        // レスポンスデータの設定(配列)
        $response = [
            'success' => true,  // 処理完了
            'like_count' => $like_count,  // 更新後のいいね数
            'is_liked' => $is_liked  // 現在のいいねの状態
        ];
    } catch (PDOException $e) {
        // データベースエラー時の処理
        error_log('PDOException - ' . $e->getMessage(), 0);
        $response = [
            'success' => false,
            'message' => 'データベースエラーが発生しました'
        ];
    }
} else {
    // ログインしていない場合や投稿IDがPOSTされていない場合の処理
    $response = [
        'success' => false,
        'message' => 'ログイン状態が無効です。'
    ];
}

// JSON形式でレスポンスを出力してスクリプトを終了
echo json_encode($response);
exit;
