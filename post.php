<?php
// デバッグ用
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// セッションがまだ開始されていない場合にのみ session_start() を呼び出す
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// ログインチェック loginCheck ();だとログインしてない人は閲覧できないのでここでは書かない
$is_logged_in = isset($_SESSION['chk_ssid']) && $_SESSION['chk_ssid'] === session_id();
?>

<!-- index.phpでis_logged_inログインチェックした結果falseだった(ログインしていない)場合に以下表示 -->
<?php if (!$is_logged_in) : ?>

  <div class="h-[90vh] w-5/6 flex flex-col flex-1 items-center bg-[#F1F6F5] rounded-lg">
    <div class="w-full flex flex-col justify-center">
      <p class="text-center m-2 p-2">ログインすると投稿できます。<br class="sm:hidden">アカウントの作成は新規登録から！</p>
      <div class="sm:w-full flex flex-col-reverse sm:flex-row justify-center sm:justify-around items-center m-2 p-2 sm:pb-4">
        <button onclick="location.href='user.php'" class="w-2/3 sm:w-1/3 md:w-1/4 border-2 rounded-md border-[#8DB1CF] text-slate-800 md:text-slate-600 bg-[#8DB1CF] md:bg-transparent md:hover:bg-[#8DB1CF] md:hover:text-white transition-colors duration-300 p-2 m-2">新規登録</button>
        <button onclick="location.href='login.php'" class="w-2/3 sm:w-1/3 md:w-1/4 border-2 rounded-md border-[#4CAF50] text-white md:text-[#4CAF50] bg-[#4CAF50] md:bg-transparent md:hover:bg-[#4CAF50] md:hover:text-white transition-colors duration-300 p-2 m-2">ログイン</button>
      </div>
    </div>
  <?php endif ?>

  <!-- Posts[start] -->
  <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
    <!-- 以下に投稿内容が表示される -->

    <?php

    require_once('funcs.php');  // 関数群の呼び出し
    require_once('db_conn.php');

    // セッションデバッグ用
    // error_log('Session data in index.php: ' . print_r($_SESSION, true));

    // DB接続
    $pdo = db_conn();

    // ログインしているユーザーの情報を取得
    $username = '';  // usernameの初期化
    if ($is_logged_in && isset($_SESSION['lid'])) {  // ログインしていてlidがある場合
      $stmt = $pdo->prepare("SELECT username FROM kadai10_user_table WHERE lid = :lid");
      $stmt->bindValue(':lid', $_SESSION['lid'], PDO::PARAM_STR);
      $stmt->execute();
      $user = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($user && isset($user['username'])) {  // $userが存在してusernameキーがあれば変数に格納
        $username = $user['username'];
      }
    }

    // データ登録処理
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // POSTで送信されたか確認
      if (
        // $_POST['message']がセットされていないor空文字(=未入力)ならtrue
        !isset($_POST['message']) || $_POST['message'] === ''
      ) { // 上記がtrueならエラーを出力
        exit('内容が入力されていません');
      }

      // メッセージが140文字を超えている場合はエラーとして処理を中断する
      if (mb_strlen($_POST['message']) > 140) {
        exit('内容は140文字以内で入力してください');
      }

      // セッションから名前を取得、未設定の場合はデフォルトで「名無しさん」
      $name = isset($_SESSION['username']) ? $_SESSION['username'] : '名無しさん';
      $message = $_POST['message'];
      $picturePath = null;

      // ファイルアップロード処理
      if (isset($_FILES['picture'])) {
        try {
          $picturePath = uploadFile($_FILES['picture']);
        } catch (Exception $e) {
          exit($e->getMessage());
        }
      }

      // データベースに保存
      if ($picturePath !== null) {
        // 写真がある場合
        $stmt = $pdo->prepare('INSERT INTO kadai10_msg_table(id, name, message, picture_path, date) VALUES(NULL, :name, :message, :picture_path, now())');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
        $stmt->bindValue(':picture_path', $picturePath, PDO::PARAM_STR);
      } else {
        // 写真がない場合
        $stmt = $pdo->prepare('INSERT INTO kadai10_msg_table(id, name, message, date) VALUES(NULL, :name, :message, now())');
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':message', $message, PDO::PARAM_STR);
      }

      $status = $stmt->execute();

      // リダイレクトなどの処理
      redirect('index.php');
    }

    // 検索処理 (POSTではなくGETが一般的 キャッシュ可 ブクマ共有可 クエリの透過性)
    // searchの値があればその値、なければ空文字を代入
    $searchWord = isset($_GET['search']) ? $_GET['search'] : '';
    // クエリの並び順を取得
    $order = isset($_GET['order']) ? $_GET['order'] : 'desc'; // デフォルトは降順

    if ($searchWord) {  // $searchWordが空でない場合
      $stmt = $pdo->prepare("SELECT * FROM kadai10_msg_table WHERE message LIKE :searchWord ORDER BY date $order");  // :searchWordで曖昧検索し降順で取得
      $stmt->bindValue(':searchWord', '%' . $searchWord . '%', PDO::PARAM_STR);
    } else {  // $searchWordが空の場合
      $stmt = $pdo->prepare("SELECT * FROM kadai10_msg_table ORDER BY date $order");
    }  // テーブル内の全データを降順で取得
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);  // 連想配列で取得し配列に格納

    // 投稿内容 検索結果の表示
    foreach ($results as $row) {
      echo '<div class="border rounded-md p-2 m-2 bg-white flex flex-col">';
      echo '<p class="text-sm sm:text-base lg:text-lg"><strong class="text-base sm:text-lg lg:text-xl">名前：</strong>' . h($row['name']) . '</p>';
      echo '<p class="text-sm sm:text-base lg:text-lg mt-2"><strong class="text-base sm:text-lg lg:text-xl">内容：</strong>' . nl2br(h($row['message'])) . '</p>';

      // 写真部分にクラスとデータ属性を設定
      echo '<div class="rounded-md overflow-hidden w-full h-auto max-w-full max-h-96 picture-modal-trigger"';
      if (!empty($row['picture_path'])) {
        echo ' data-img-src="' . h($row['picture_path']) . '"'; // モーダルに表示する画像データ
      }
      echo '>';

      // pictureが空でなければbase64エンコードされた画像データを表示
      if (!empty($row['picture_path'])) {
        echo '<img src="' . $row['picture_path'] . '" alt="写真" class="w-full h-auto max-w-full max-h-[90vh] object-contain">';
      }
      echo '</div>';
      echo '<div class="mt-auto">';
      echo '<p class=" text-sm sm:text-base lg:text-lg"><strong class="text-base sm:text-lg lg:text-xl">投稿：</strong>' . h($row['date']) . '</p>';
      if ($row['updated_at']) {
        echo '<p class="text-sm sm:text-base lg:text-lg"><strong class="text-base sm:text-lg lg:text-xl">更新：</strong>' . h($row['updated_at']) . '</p>';
      }
      echo '</div>';

      // ログインしている場合
      if ($is_logged_in) {
        // いいねボタンといいね数の表示 data-user-id属性に現在のユーザーIDを設定→jsで触る
        echo '<div class="like-section" data-user-id="' . h($_SESSION['lid']) . '">';
        // 現在のユーザーがこの投稿にいいねしているかどうかをチェック
        $is_liked = checkUserLike($pdo, $_SESSION['lid'], $row['id']);
        // いいねしている場合はクラス 'liked' を、していない場合は空文字を設定
        $like_class = $is_liked ? 'liked' : '';
        // いいねしている場合は 'fa-solid' アイコンを、していない場合は 'fa-regular' アイコンを設定
        $heart_icon = $is_liked ? 'fa-solid' : 'fa-regular';
        // いいねボタンのHTMLを生成。data-post-id 属性に投稿IDを設定→jsで触る
        echo '<button class="like-button mr-2 ' . $like_class . '" data-post-id="' . $row['id'] . '"><i class="' . $heart_icon . ' fa-heart"></i></button>';
        // 投稿のいいね数を取得
        $like_count = getLikeCount($pdo, $row['id']);
        // いいね数を表示するHTMLを生成
        echo '<span class="like-count-number">' . $like_count . '</span>';
        echo '</div>';

        echo '<div class="flex justify-center">';
        // ログインしているユーザーが投稿者である場合に編集ボタンを表示
        if ($_SESSION['username'] === $row['name']) {
          echo '<button type="button" onclick="location.href=\'edit.php?id=' . $row['id'] . '\'" class="w-1/4 border-2 rounded-md border-[#93CCCA] md:border md:border-slate-200  text-[#93CCCA] md:bg-transparent md:text-inherit md:hover:bg-[#93CCCA] transition-colors duration-300 p-2 m-2"><i class="fas fa-edit"></i></button>';
        }

        // ログインしているユーザーが投稿者である場合、または管理者の場合に削除ボタンを表示
        if ($_SESSION['username'] === $row['name'] || $_SESSION['kanri'] === 1) {
          echo '<button type="button" onclick="location.href=\'delete.php?id=' . $row['id'] . '\'" class="w-1/4 border-2 rounded-md border-[#B33030] md:border md:border-slate-200  text-[#B33030] md:bg-transparent md:text-inherit md:hover:bg-[#B33030] md:hover:text-white transition-colors duration-300 p-2 m-2"><i class="fas fa-trash-alt"></i></button>';
        }
        echo '</div>';
      }
      echo '</div>';
    }
    ?>
  </div>
  <!-- Posts[End] -->
  </div>
  <!-- Display area[End] -->
  </div>
  <!-- Main[End] -->