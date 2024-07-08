<?php include 'head.php'; ?> <!-- ヘッダー -->

<!-- Main[Start] -->
<div class="h-[60vh] w-[60vw] flex flex-col justify-center items-center bg-[#F1F6F5] rounded-lg">
    <!-- <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">投稿一覧</a>
        </div>
    </div> -->

    <!-- login_act.php は認証処理用のPHPです。 -->
    <form name="form1" action="login_act.php" method="post" class="w-full flex flex-col justify-center items-center m-2">
        <div class="w-full flex flex-col justify-center m-2">
            <div class="p-4">
                <label for="lid" class="text-sm sm:text-base md:text-lg lg:text-xl">ログインID：<small class="text-slate-600"> (半角英数字で入力してください) </small></label>
                <input type="text" name="lid" id="lid" placeholder="example123" required class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="p-4">
                <label for="password" class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD：<small class="text-slate-600"> (半角英数字で入力してください) </small></label>
                <input type="password" name="password" id="password" placeholder="pass01" class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="w-full flex flex-row justify-around items-center m-2 p-4">
                <button onclick="location.href='user.php'" class="w-1/4 border-2 rounded-md border-[#93CCCA] text-[#93CCCA] md:bg-transparent md:hover:bg-[#93CCCA] md:hover:text-white p-2 m-2">新規登録</button>
                <input type="submit" value="LOGIN" class="w-1/4 border-2 rounded-md border-[#4CAF50] text-[#4CAF50] md:bg-transparent md:hover:bg-[#4CAF50] md:hover:text-white p-2 m-2" />
            </div>
        </div>
    </form>
</div>
<!-- Main[End] -->
<?php include 'foot.php'; ?> <!-- フッター -->