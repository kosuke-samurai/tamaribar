<?php
//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();

//var_dump($_GET);
//exit();
// id受け取り

session_start();
include("functions.php");
check_store_session_id();

// DB接続


$id = $_GET["id"];

$pdo = connect_to_db();

// SQL実行
$sql = 'SELECT * FROM store_db WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);

try {
  $status = $stmt->execute();
} catch (PDOException $e) {
  echo json_encode(["sql error" => "{$e->getMessage()}"]);
  exit();
}

$record = $stmt->fetch(PDO::FETCH_ASSOC);
//var_dump($record);
//exit();

?>

<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
  <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
  <link rel="stylesheet" href="css/store_input.css">
  <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
  <title>たまりbar</title>
</head>

<body>
  <header class="store_header">
    <div class="header__wrapper">
      <div>
        <h1 class="tamari_family">たまりbar</h1>
        <p class="tamari_family">移住者のコミュニティーが生まれる</p>
        <p>管理者名:<?= $_SESSION['username']; ?></p>
      </div>

      <ul class="nav__list">
        <li class="nav-item"><a href="store_manege.php">管理者ページに戻る</a></li>
        <li class="nav-item"><a href="index.php">トップに戻る</a></li>
        <li class="nav-item"><a href="store_logout.php">ログアウトする</a></li>
        <li class="nav-item"><a href="store_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a></li>
      </ul>

    </div>

  </header>




  <main>
    <h2>店舗情報の編集</h2>

    <form action="store_manege_update.php" method="POST" enctype="multipart/form-data">

      <input type="hidden" name="username" class="info" value="<?= $record['username'] ?>">
      <input type="hidden" name="id" value="<?= $record['id'] ?>">
      <input type="hidden" name="filesurl" id="filesurl" value="<?= $record['filesurl'] ?>">

      <dl class="input">
        <dt class="store_required">店舗名</dt>
        <dd><input type="text" name="name" class="info" value="<?= $record['name'] ?>" required></dd>

        <dt class="store_required">店舗メイン写真</dt>
        <dd><input type="file" onchange="uploadData()" id="files" name="Files[]" multiple></dd>



        <dt class="store_required">カテゴリー</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="category" value="居酒屋" class="category" required <?php if ($record['category'] == "居酒屋") echo 'checked'; ?>>居酒屋</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="バー" class="category" required <?php if ($record['category'] == "バー") echo 'checked'; ?>>バー</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="カフェ" class="category" required <?php if ($record['category'] == "カフェ") echo 'checked'; ?>>カフェ</label>
            </li>
            <li>
              <label><input type="radio" name="category" value="その他" class="category" required <?php if ($record['category'] == "その他") echo 'checked'; ?>>その他</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">メイン客層は</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="moodselect" value="20代ぐらいの人が多め" class="category" required <?php if ($record['moodselect'] == "20代ぐらいの人が多め") echo 'checked'; ?>>20代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="30代ぐらいの人が多め" class="category" required <?php if ($record['moodselect'] == "30代ぐらいの人が多め") echo 'checked'; ?>>30代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="40代ぐらいの人が多め" class="category" required <?php if ($record['moodselect'] == "40代ぐらいの人が多め") echo 'checked'; ?>>40代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="50代ぐらいの人が多め" class="category" required <?php if ($record['moodselect'] == "50代ぐらいの人が多め") echo 'checked'; ?>>50代ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="60代以上ぐらいの人が多め" class="category" required <?php if ($record['moodselect'] == "60代以上ぐらいの人が多め") echo 'checked'; ?>>60代以上ぐらいの人が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="お一人様が多め" class="category" required <?php if ($record['moodselect'] == "お一人様が多め") echo 'checked'; ?>>お一人様が多め</label>
            </li>
            <li>
              <label><input type="radio" name="moodselect" value="ファミリーが多め" class="category" required <?php if ($record['moodselect'] == "ファミリーが多め") echo 'checked'; ?>>ファミリーが多め</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">お店の雰囲気をアピールしてください</dt>
        <dd><textarea type="textarea" name="moodtext" cols="30" rows="5" class="info" required><?= $record['moodtext'] ?></textarea></dd>

        <dt class="store_required">提供メニューをアピールしてください</dt>
        <dd><textarea type="textarea" name="foodtext" cols="30" rows="5" class="info" required><?= $record['foodtext'] ?></textarea></dd>

        <dt class="store_required">利用移住者に贈るメッセージを記入してください</dt>
        <dd><textarea type="textarea" name="message" cols="30" rows="5" class="info" required><?= $record['message'] ?></textarea></dd>

        <dt class="store_required">利用できる時間帯は</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="scene" value="お昼" class="category" required <?php if ($record['scene'] == "お昼") echo 'checked'; ?>>お昼</label>
            </li>
            <li>
              <label><input type="radio" name="scene" value="夜" class="category" required <?php if ($record['scene'] == "夜") echo 'checked'; ?>>夜</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">予算</dt>
        <dd>
          <ul>
            <li>
              <label><input type="radio" name="budget" value="~1000円" class="category" required <?php if ($record['budget'] == "~1000円") echo 'checked'; ?>>~1000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="1000円〜3000円" class="category" required <?php if ($record['budget'] == "1000円〜3000円") echo 'checked'; ?>>1000円〜3000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="3000円〜5000円" class="category" required <?php if ($record['budget'] == "3000円〜5000円") echo 'checked'; ?>>3000円〜5000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="5000円〜7000円" class="category" required <?php if ($record['budget'] == "5000円〜7000円") echo 'checked'; ?>>5000円〜7000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="7000円〜10000円" class="category" required <?php if ($record['budget'] == "7000円〜10000円") echo 'checked'; ?>>7000円〜10000円</label>
            </li>
            <li>
              <label><input type="radio" name="budget" value="10000円〜" class="category" required <?php if ($record['budget'] == "10000円〜") echo 'checked'; ?>>10000円〜</label>
            </li>
          </ul>
        </dd>

        <dt class="store_required">お店の開業日</dt>
        <dd><input type="date" name="openday" class="info" required value="<?= $record['openday'] ?>"></dd>

        <dt class="store_required">郵便番号（7桁ハイフンなし）</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required value="<?= $record['postadress'] ?>" maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','adress','adress');"></dd>

        <dt class="store_required">住所</dt>
        <dd><input type="text" name="adress" class="info" required value="<?= $record['adress'] ?>"></dd>

        <dt class="store_required">電話番号</dt>
        <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required value="<?= $record['tell'] ?>"></dd>

        <div>
          <button id="up" class="store_button">送信</button>
        </div>
      </dl>



    </form>

  </main>
  <footer>@高橋</footer>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/8.10.1/firebase-storage.js"></script>

  <script>
    // Import the functions you need from the SDKs you need
    //import { initializeApp } from "https://www.gstatic.com/firebasejs/9.8.2/firebase-app.js";
    // TODO: Add SDKs for Firebase products that you want to use
    // https://firebase.google.com/docs/web/setup#available-libraries
    const hogeArray = <?= json_encode(getenv('FIREBASE_KEY')); ?>;

    // Your web app's Firebase configuration
    const firebaseConfig = {
      apiKey: hogeArray,
      authDomain: "graduationprogram-45052.firebaseapp.com",
      projectId: "graduationprogram-45052",
      storageBucket: "graduationprogram-45052.appspot.com",
      messagingSenderId: "1072965734538",
      appId: "1:1072965734538:web:df27027e247be303ca5d73"
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    //"Images"=フォルダ名
    let storageRef = firebase.storage().ref("Store_main_img");


    function uploadData() {
      let file = document.getElementById('files').files[0];
      console.log(file);
      console.log(file.name);

      let thisRef = storageRef.child(file.name)

      //アップロードの処理！
      thisRef.put(file)
        .then(res => {
          console.log(res)
          console.log("アップロード成功");
          alert("アップロード成功");
          storageRef.child(file.name).getDownloadURL()
            .then(url => {
              const filesurl = document.getElementById("filesurl")
              //console.log(filesurl.value);
              console.log(url);
              filesurl.value = url;

            }).catch(e => {
              console.log(e);
            })
        }).catch(e => {
          console.log("Error " + e);

        }).then(
          //URLダウンロード
          // storageRef.child(file.name).getDownloadURL().then(url => {
          //   const filesurl = document.getElementById("filesurl")
          //   //console.log(filesurl.value);
          //   console.log(url);
          //   filesurl.value = url;

          // }).catch(e => {
          //   console.log(e);
          // })
        );

    }

    /*
        storageRef.child(file.name).getDownloadURL().then(url => {
          console.log(url);
          filesurl.value = url;
        }).catch(e => {
          console.log(e);
        });
        */




    /*
        function download() {
          uploadData(() => {
            storageRef.child(file.name).getDownloadURL().then(url => {
              console.log(url);
              filesurl.value = url;
            }).catch(e => {
              console.log(e);
            });
          });
        }

        download();

        //const filesurl = document.getElementById("filesurl")
        //console.log(filesurl.value);

    */

    //画像の削除
    /*
    storageRef.child("bg_pattern4_yoru.png").delete().then(url => {
        alert("削除したよん");
    }).catch(e => {
        console.log(e);
    })
    */
  </script>

</body>

</html>