<?php include 'head.php'; ?> <!-- ヘッダー -->

<!-- Main[Start] -->
<div class="h-[60vh] w-[60vw] flex flex-col justify-center sm:justify-start items-center bg-[#F1F6F5] rounded-lg">

<!-- login_act.php は認証処理用のPHPです。 -->
    <form name="form1" action="login_act.php" method="post" class="w-full flex flex-col justify-center items-center m-2 sm:my-auto">
        <div class="w-full flex flex-col justify-center m-2">
            <div class="p-4">
                <label for="lid" class="text-sm sm:text-base md:text-lg lg:text-xl">ログインID：<br class="sm:hidden"><small class="text-slate-600"> (半角英数字で入力してください) </small></label>
                <input type="text" name="lid" id="lid" placeholder="example123" required class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="p-4">
                <label for="password" class="text-sm sm:text-base md:text-lg lg:text-xl">PASSWORD：<br class="sm:hidden"><small class="text-slate-600"> (半角英数字で入力してください) </small></label>
                <input type="password" name="password" id="password" placeholder="pass01" class="w-full h-11 p-2 border rounded-md">
            </div>
            <div class="sm:w-full flex flex-col sm:flex-row justify-center sm:justify-around items-center m-2 p-2">
                <button onclick="location.href='user.php'" class="w-3/4 sm:w-1/4 border-2 rounded-md border-[#8DB1CF] text-slate-600 bg-transparent hover:bg-[#8DB1CF] hover:text-white transition-colors duration-300 p-2 m-2">新規登録</button>
                <input type="submit" value="LOGIN" class="w-3/4 sm:w-1/4 border-2 rounded-md border-[#4CAF50] text-[#4CAF50] bg-transparent hover:bg-[#4CAF50] hover:text-white transition-colors duration-300 p-2 m-2" />
            </div>
        </div>
    </form>
</div>
<!-- Main[End] -->
<?php include 'foot.php'; ?> <!-- フッター -->