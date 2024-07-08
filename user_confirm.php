<?php
include 'head.php';
require_once('funcs.php');

// POSTデータの取得
$username = isset($_POST['username']) ? h($_POST['username']) : '';
$email = isset($_POST['email']) ? h($_POST['email']) : '';
$password_display = '********'; // パスワードは表示しないため、ダミーの文字列を表示する
$pass_confirm_display = '********'; // 確認用パスワードも同様に表示しない
$user_type = isset($_POST['user_type']) ? h($_POST['user_type']) : 'normal'; // ユーザータイプのデフォルトは一般ユーザー
$admin_password = $_POST['admin_password'];
?>

<!-- Main[Start] -->
<div class="max-h-screen w-5/6 flex flex-col flex-1 items-center bg-[#F1F6F5] rounded-lg p-4">
  <h2 class="text-lg md:text-xl lg:text-2xl mb-4">入力内容の確認</h2>
  <div class="w-full flex flex-col justify-center items-start m-2 p-4 border rounded-md bg-white">
    <div class="p-4">
      <label class="text-sm sm:text-base md:text-lg lg:text-xl">ユーザー名：</label>
      <p class="w-full h-11 p-2 border rounded-md"><?php echo $username; ?></p>
    </div>
    <div class="p-4">
      <label class="text-sm sm:text-base md:text-lg lg:text-xl">EMAIL：</label>
      <p class="w-full h-11 p-2 border rounded-md"><?php echo $email; ?></p>
    </div>
    <div class="p-4">
      <label class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD：</label>
      <p class="w-full h-11 p-2 border rounded-md"><?php echo $password_display; ?></p>
    </div>
    <div class="p-4">
      <label class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD(確認用)：</label>
      <p class="w-full h-11 p-2 border rounded-md"><?php echo $pass_confirm_display; ?></p>
    </div>
    <div class="p-4">
      <label class="text-sm sm:text-base md:text-lg lg:text-xl">ユーザータイプ：</label>
      <p class="w-full h-11 p-2 border rounded-md"><?php echo ($user_type === 'admin') ? '管理者' : '一般ユーザー'; ?></p>
    </div>
  </div>
  <!-- 隠しフィールドでデータを登録 -->
  <form action="user_submit.php" method="post" class="w-full flex flex-col justify-center items-center m-2">
    <input type="hidden" name="username" value="<?php echo h($_POST['username']); ?>">
    <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
    <input type="hidden" name="password" value="<?php echo h($_POST['password']); ?>">
    <input type="hidden" name="pass_confirm" value="<?php echo h($_POST['pass_confirm']); ?>">
    <input type="hidden" name="user_type" value="<?php echo h($_POST['user_type']); ?>">
    <input type="hidden" name="admin_password" value="<?php echo h($_POST['admin_password']); ?>">
    <button type="submit" class="w-1/2 border-2 rounded-md border-[#4CAF50] text-[#4CAF50] md:bg-transparent md:hover:bg-[#4CAF50] md:hover:text-white p-2 m-2">確認して登録</button>
  </form>
  <button type="button" onclick="history.back()" class="w-1/2 border-2 rounded-md border-[#B33030] text-[#B33030] md:bg-transparent md:hover:bg-[#B33030] md:hover:text-white p-2 m-2">戻る</button>
</div>
<!-- Main[End] -->

<?php include 'foot.php'; ?> <!-- フッター -->