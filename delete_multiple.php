<?php
session_start();
require_once('funcs.php');
require_once('db_conn.php');
loginCheck();

// DB接続
$pdo = db_conn();

// POSTデータのチェック
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_ids'])) {
  $delete_ids = $_POST['delete_ids'];

  // 削除する投稿のIDが配列であるか確認
  if (is_array($delete_ids) && count($delete_ids) > 0) {
    try {
      // トランザクション開始
      $pdo->beginTransaction();

      // 投稿の削除クエリ
      $postStmt = $pdo->prepare("DELETE FROM kadai10_msg_table WHERE id IN (" . implode(',', array_fill(0, count($delete_ids), '?')) . ")");
      
      // プレースホルダに値をバインドしてクエリ実行
      foreach ($delete_ids as $k => $id) {
        $postStmt->bindValue(($k + 1), $id, PDO::PARAM_INT);
      }
      
      $postStmt->execute();

      // ユーザーの削除クエリ
      $userStmt = $pdo->prepare("DELETE FROM kadai10_user_table WHERE id IN (" . implode(',', array_fill(0, count($delete_ids), '?')) . ")");
      
      // プレースホルダに値をバインドしてクエリ実行
      foreach ($delete_ids as $k => $id) {
        $userStmt->bindValue(($k + 1), $id, PDO::PARAM_INT);
      }
      
      $userStmt->execute();

      // コミット
      $pdo->commit();
    } catch (PDOException $e) {
      // ロールバック
      $pdo->rollBack();
      // エラー処理などを行う場合に記述します
      // 例: echo "削除に失敗しました。エラー: " . $e->getMessage();
    }
  }
}

// 管理者画面にリダイレクト
redirect('admin.php');
?>
