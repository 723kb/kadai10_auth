<?php include 'head.php'; ?> <!-- ヘッダー -->

<!-- Main[Start] -->
<div class="max-h-screen w-5/6 flex flex-col flex-1 items-center bg-[#F1F6F5] rounded-lg">
  <form action="user_confirm.php" method="post" class="w-full flex flex-col justify-center items-center m-2">
    <div class="w-full flex flex-col justify-center m-2">
    <div class="p-4">
        <label for="lid" class="text-sm sm:text-base md:text-lg lg:text-xl">ログインID：</label>
        <input type="text" name="lid" id="lid" placeholder="example123" required class="w-full h-11 p-2 border rounded-md">
      </div>
      <div class="p-4">
        <label for="username" class="text-sm sm:text-base md:text-lg lg:text-xl">ユーザー名：</label>
        <input type="text" name="username" id="username" placeholder="テストちゃん" required class="w-full h-11 p-2 border rounded-md">
      </div>
      <div class="p-4">
        <label for="email" class="text-sm sm:text-base md:text-lg lg:text-xl">EMAIL：</label>
        <input type="email" name="email" id="email" placeholder="test@test.com" required class="w-full h-11 p-2 border rounded-md">
      </div>
      <div class="p-4">
        <label for="password" class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD：</label>
        <input type="password" name="password" id="password" placeholder="pass01" required class="w-full h-11 p-2 border rounded-md">
      </div>
      <div class="p-4">
        <label for="pass_confirm" class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD(確認用)：</label>
        <input type="password" name="pass_confirm" id="pass_confirm" placeholder="pass01" required class="w-full h-11 p-2 border rounded-md">
      <div class="p-4">
        <label class="text-sm sm:text-base md:text-lg lg:text-xl">ユーザータイプ：</label><br>
        <input type="radio" id="normal_user" name="user_type" value="normal" checked>
        <label for="normal_user">一般ユーザー</label><br>
        <input type="radio" id="admin_user" name="user_type" value="admin">
        <label for="admin_user">管理者</label>
      </div>
      <!-- 管理者用のパスワード入力 -->
      <div id="admin_password_section" class="p-4 hidden">
        <label for="admin_password" class="text-sm sm:text-base md:text-lg lg:text-xl">管理者パスワード：</label>
        <input type="password" name="admin_password" id="admin_password" placeholder="管理者パスワードを入力してください" class="w-full h-11 p-2 border rounded-md">
      </div>
      <button type="submit">次へ</button>
    </div>
  </form>
</div>
<!-- Main[End] -->

<script>
  // 管理者ラジオボタンが選択された時の処理
  document.getElementById('admin_user').addEventListener('change', function() {
    document.getElementById('admin_password_section').classList.remove('hidden');
  });

  // 一般ユーザーまたは管理者以外が選択された時の処理
  document.getElementById('normal_user').addEventListener('change', function() {
    document.getElementById('admin_password_section').classList.add('hidden');
  });
</script>

<?php include 'foot.php'; ?> <!-- フッター -->