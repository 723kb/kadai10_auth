<?php
session_start();
include 'head.php';

require_once('db_conn.php');
require_once('funcs.php');
loginCheck();

// DB接続
$pdo = db_conn();

// ユーザー一覧と投稿一覧を取得するクエリ
$stmtUsers = $pdo->query('SELECT * FROM kadai10_user_table');
$users = $stmtUsers->fetchAll(PDO::FETCH_ASSOC);

$stmtPosts = $pdo->query('SELECT * FROM kadai10_msg_table');
$posts = $stmtPosts->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- HamburgerMenu -->
<nav>
  <button id="button" type="button" class="fixed top-3 right-6 z-10 text-slate-600 hover:bg-white transition-colors duration-300 p-1 rounded-md">
    <i id="bars" class="fa-solid fa-bars fa-2x"></i>
  </button>
  <ul id="menu" class="fixed top-0 left-0 z-0 w-full translate-x-full bg-[#8DB1CF] text-center text-xl font-bold text-white transition-all ease-linear">
    <button onclick="showUsers()" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] hover:text-slate-600 transition-colors duration-300 p-2 m-2">登録者一覧</button>
    <button onclick="showPosts()" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] hover:text-slate-600 transition-colors duration-300 p-2 m-2">投稿一覧</button>
    <button onclick="location.href='index.php'" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] hover:text-slate-600 transition-colors duration-300 p-2 m-2">ホーム</button>
  </ul>
</nav>
<!-- Main[Start] -->
<div class="w-[90vw] min-h-screen flex flex-col sm:flex-row bg-white rounded-lg">

  <!-- サイドバー -->
  <!-- <div class="w-full sm:w-1/4 flex flex-col">
    <button onclick="location.href='index.php'" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] p-2 m-2">ホーム</button>
    <button onclick="showUsers()" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] p-2 m-2">登録者一覧</button>
    <button onclick="showPosts()" class="border-2 border-slate-200 rounded-md py-3 px-6 bg-[#D1D1D1] md:bg-transparent md:hover:bg-[#D1D1D1] p-2 m-2">投稿一覧</button>
  </div> -->
  <!-- 表示エリア -->
  <div id="contentArea" class="w-full border-t sm:border">
    <div id="userList" class="">
      <form id="deleteUserForm" method="POST" action="delete_multiple.php" onsubmit="return confirm('選択したユーザーを削除しますか？');">
        <h2 class="text-center text-xl mx-auto mt-4 sm:mb-4">登録者一覧</h2>
        <div class="flex justify-center mt-4">
          <?php if ($_SESSION['kanri'] === 1) : ?>
            <button type="submit" class=" border-2 rounded-md border-[#B33030] text-[#B33030] bg-transparent hover:bg-[#B33030] hover:text-white transition-colors duration-300 p-2 m-2"><i class="fas fa-trash-alt"></i> 選択した項目を削除</button>
          <?php endif; ?>
        </div>
        <ul>
          <?php foreach ($users as $user) : ?>
            <label class="block border-t sm:border-b sm:border-t-0 p-4 mb-4 cursor-pointer">
              <input type="checkbox" name="delete_ids[]" value="<?= $user['id'] ?>" class="mr-2">
              <div>
                <strong>ID: </strong><?php echo h($user['id']); ?><br>
                <strong>ログインID: </strong><?php echo h($user['lid']); ?><br>
                <strong>ユーザー名: </strong><?php echo h($user['username']); ?><br>
                <strong>EMAIL: </strong><?php echo h($user['email']); ?><br>
                <strong>ユーザータイプ: </strong><?php echo h($user['kanri_flg'] == 1 ? '管理者' : '一般ユーザー'); ?><br>
                <strong>登録日時: </strong><?php echo h($user['indate']); ?><br>
              </div>
            </label>
          <?php endforeach; ?>
        </ul>
      </form>
    </div>
    <div id="postList" class="hidden">
      <h2 class="text-center text-xl mx-auto mt-4 sm:mb-4">投稿一覧</h2>
      <form id="deletePostForm" method="POST" action="delete_multiple.php" onsubmit="return confirm('選択した投稿を削除しますか？');">
        <div class="flex justify-center mt-4">
          <?php if ($_SESSION['kanri'] === 1) : ?>
            <button id="delete" type="submit" class=" border-2 rounded-md border-[#B33030] text-[#B33030] bg-transparent hover:bg-[#B33030] hover:text-white transition-colors duration-300 p-2 m-2"><i class="fas fa-trash-alt"></i> 選択した項目を削除</button>
          <?php endif; ?>
        </div>
        <ul>
          <?php foreach ($posts as $post) : ?>
            <label class="block border-t sm:border-b sm:border-t-0 p-4 mb-4 cursor-pointer">
              <input type="checkbox" name="delete_ids[]" value="<?= $post['id'] ?>" class="mr-2">
              <div>
                <strong>ユーザー名: </strong><?php echo h($post['name']); ?><br>
                <strong>内容: </strong><?php echo h($post['message']); ?><br>
                <?php if (isset($post['picture'])) : ?>
                  <strong>画像: </strong><br>
                  <img src="data:image/jpeg;base64,<?php echo base64_encode($post['picture']); ?>" alt="投稿画像" class="my-2">
                <?php endif; ?>
                <strong>投稿日時: </strong><?php echo h($post['date']); ?><br>
                <?php if (isset($post['updated_at'])) : ?>
                  <strong>更新日時: </strong><?php echo h($post['updated_at']); ?><br>
                <?php endif; ?>
              </div>
            </label>
          <?php endforeach; ?>
        </ul>
      </form>
    </div>
  </div>
</div>

<!-- クリックで表示を切り替える -->
<script>
  function showUsers() {
    document.getElementById('userList').classList.remove('hidden');
    document.getElementById('postList').classList.add('hidden');
  }

  function showPosts() {
    document.getElementById('userList').classList.add('hidden');
    document.getElementById('postList').classList.remove('hidden');
  }

  button.addEventListener('click', event => {
    bars.classList.toggle('hidden')

    menu.classList.toggle('translate-x-full')
  });
</script>

<?php
// foot.phpを含むフッター部分
include 'foot.php';
?>