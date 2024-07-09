<?php
session_start();
require_once('funcs.php');

// ログイン状態をチェック
$is_logged_in = isset($_SESSION['chk_ssid']) && $_SESSION['chk_ssid'] === session_id();
?>

<?php include 'head.php'; ?> <!-- ヘッダー -->

<?php if ($is_logged_in): ?>
    <?php 
    // セッションIDの再生成
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
    
    include 'post_form.php'; ?> <!-- 入力検索エリア（ログインユーザーのみ） -->
<?php endif; ?>

<?php include 'post.php'; ?> <!-- 表示エリア（全ユーザー） -->

<?php include 'foot.php'; ?> <!-- フッター -->

<script src="js/app.js"></script> <!-- post.php/post_form.php部分のjs -->