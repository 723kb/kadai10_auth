<?php
// head.phpを含むヘッダー部分
include 'head.php';

// データベース接続とfuncs.phpの読み込み
require_once('db_conn.php');
require_once('funcs.php');

// DB接続
$pdo = db_conn();

// ユーザー一覧を取得するクエリ
$stmtUsers = $pdo->query('SELECT * FROM kadai10_user_table');
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

// 投稿一覧を取得するクエリ
$stmtPosts = $pdo->query('SELECT * FROM kadai10_msg_table');
$posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Main[Start] -->
<div class="w-full min-h-screen flex flex-row">
    <div class="w-1/3 bg-white flex flex-col">
        <!-- サイドバー -->
        <button onclick="showUsers()">ユーザー一覧</button>
        <button onclick="showPosts()">投稿一覧</button>
    </div>
    <div id="contentArea" class="w-2/3 bg-pink-200">
        <!-- 表示エリア -->
        <div id="userList" class="hidden">
            <h2 class="text-xl mb-4">ユーザー一覧</h2>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li><?php echo h($user['username']); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div id="postList" class="hidden">
            <h2 class="text-xl mb-4">投稿一覧</h2>
            <ul>
            <?php foreach ($posts as $post): ?>
    <div class="border p-4 mb-4">
        <strong>投稿者名: </strong><?php echo h($post['name']); ?><br>
        <strong>投稿日時: </strong><?php echo h($post['date']); ?><br>
        <strong>メッセージ: </strong><?php echo h($post['message']); ?><br>
        <?php if (isset($post['picture'])): ?>
            <strong>画像: </strong><br>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($post['picture']); ?>" alt="投稿画像" class="my-2">
        <?php endif; ?>
        <?php if (isset($post['update_at'])): ?>
            <strong>更新日時: </strong><?php echo h($post['update_at']); ?><br>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

            </ul>
        </div>
    </div>
</div>

<script>
    function showUsers() {
        document.getElementById('userList').classList.remove('hidden');
        document.getElementById('postList').classList.add('hidden');
    }

    function showPosts() {
        document.getElementById('userList').classList.add('hidden');
        document.getElementById('postList').classList.remove('hidden');
    }
</script>

<?php
// foot.phpを含むフッター部分
include 'foot.php';
?>
