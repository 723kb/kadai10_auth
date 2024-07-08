<?php include 'head.php'; ?> <!-- ヘッダー -->

<!-- Main[Start] -->
<div class="max-h-screen w-5/6 flex flex-col flex-1 items-center bg-[#F1F6F5] rounded-lg">



    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">投稿一覧</a>
        </div>
    </div>


    <!-- login_act.php は認証処理用のPHPです。 -->
    <form name="form1" action="login_act.php" method="post" class="w-full flex flex-col justify-center items-center m-2">
        <div class="w-full flex flex-col justify-center m-2">
            <div class="p-4">
                <label for="username" class="text-sm sm:text-base md:text-lg lg:text-xl">ユーザー名：</label>
                <input type="text" name="username" id="username" placeholder="user01" class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="p-4">
                <label for="password" class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD：</label>
                <input type="password" name="password" id="password" placeholder="pass01" class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="p-4">
                <input type="submit" value="LOGIN" />
            </div>
        </div>
    </form>
    <div class="navbar-header">
            <a class="navbar-brand" href="user.php">新規登録</a>
        </div>
</div>
<!-- Main[End] -->
<?php include 'foot.php'; ?> <!-- フッター -->