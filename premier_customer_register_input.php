<?php
session_start();
include('functions.php');
$pdo = connect_to_db();

// SQL作成&実行

$sql = "SELECT * FROM users_table";

$stmt = $pdo->prepare($sql);


// SQL実行（実行に失敗すると `sql error ...` が出力される）※基本変えない。
try {
    $status = $stmt->execute();
    //fetchAll() 関数でデータ自体を取得する．
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //できているか確認する際、テーブルを見やすくするコツ
    //echo '<pre>';
    //var_dump($result);
    //echo '</pre>';
    //exit();
    $username = [];
    foreach ($result as $record) {

        //header('Content-type: ' . $result['pictype']);
        //echo $result['picture'];
        $username[] = array($record);
    }
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_input.css">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>たまりbar</title>

    <meta property="og:site_name" content="たまりBAR">
    <meta property="og:title" content="たまりBAR">
    <meta property="og:description" content="「秘密のアイテム」で移住者にコミュニティーを。地方圏移住を促す新たな飲食店予約サービス。">
    <meta property="og:url" content="https://tamaribar.herokuapp.com">
    <meta property="og:type" content="article">
    <meta property="og:image" content="https://tamaribar.herokuapp.com/img/tamaribar_ogp.png">
    <meta name="twitter:card" content="summary_large_image">
</head>

<body>
    <header>
        <div class="header__wrapper">
            <div class="tamari_family">
                <h1>たまりbar</h1>
                <p>移住者のコミュニティーが生まれる</p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="customer_login.php">ログイン</a></li>
            </ul>

        </div>
    </header>



    <main>


        <h2 class="text-center info2">決済が完了しました。</br>続いてユーザー情報を登録してください。</h2>


        <form action="customer_register_create.php" method="POST">

            <input type="text" name="is_premier" value="有料プラン">
            <input type="text" name="is_admin" value="0">
            <input type="text" name="is_deleted" value="0">

            <dl class="input">

                <dt class="required">ユーザー名</dt>
                <dd><input type="text" name="username" id="username" onchange="inputName(this)" class="info" required></dd>

                <div class="tooltip" id="namealert">すでに登録されているため使えません</div>


                <dt class="required">メールアドレス</dt>
                <dd><input type="email" name="email" id="email" onchange="inputMail(this)" class="info" required></dd>

                <div class="tooltip2" id="emailalert">すでに登録されているため使えません</div>

                <dt class="required">パスワード</dt>
                <dd><input type="text" name="password" class="info" required></dd>


                <dt class="required">郵便番号（7桁ハイフンなし）</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="postadress" class="info" required maxlength="8" onKeyUp="AjaxZip3.zip2addr(this,'','prefectures','adress');"></dd>

                <dt class="required">都道府県</dt>
                <dd>
                    <select name="prefectures" class="info">
                        <option value="" selected>都道府県</option>
                        <option value="北海道">北海道</option>
                        <option value="青森県">青森県</option>
                        <option value="岩手県">岩手県</option>
                        <option value="宮城県">宮城県</option>
                        <option value="秋田県">秋田県</option>
                        <option value="山形県">山形県</option>
                        <option value="福島県">福島県</option>
                        <option value="茨城県">茨城県</option>
                        <option value="栃木県">栃木県</option>
                        <option value="群馬県">群馬県</option>
                        <option value="埼玉県">埼玉県</option>
                        <option value="千葉県">千葉県</option>
                        <option value="東京都">東京都</option>
                        <option value="神奈川県">神奈川県</option>
                        <option value="新潟県">新潟県</option>
                        <option value="富山県">富山県</option>
                        <option value="石川県">石川県</option>
                        <option value="福井県">福井県</option>
                        <option value="山梨県">山梨県</option>
                        <option value="長野県">長野県</option>
                        <option value="岐阜県">岐阜県</option>
                        <option value="静岡県">静岡県</option>
                        <option value="愛知県">愛知県</option>
                        <option value="三重県">三重県</option>
                        <option value="滋賀県">滋賀県</option>
                        <option value="京都府">京都府</option>
                        <option value="大阪府">大阪府</option>
                        <option value="兵庫県">兵庫県</option>
                        <option value="奈良県">奈良県</option>
                        <option value="和歌山県">和歌山県</option>
                        <option value="鳥取県">鳥取県</option>
                        <option value="島根県">島根県</option>
                        <option value="岡山県">岡山県</option>
                        <option value="広島県">広島県</option>
                        <option value="山口県">山口県</option>
                        <option value="徳島県">徳島県</option>
                        <option value="香川県">香川県</option>
                        <option value="愛媛県">愛媛県</option>
                        <option value="高知県">高知県</option>
                        <option value="福岡県">福岡県</option>
                        <option value="佐賀県">佐賀県</option>
                        <option value="長崎県">長崎県</option>
                        <option value="熊本県">熊本県</option>
                        <option value="大分県">大分県</option>
                        <option value="宮崎県">宮崎県</option>
                        <option value="鹿児島県">鹿児島県</option>
                        <option value="沖縄県">沖縄県</option>
                    </select>
                </dd>

                <dt class="required">それ以降の住所</dt>
                <dd><input type="text" name="adress" class="info" required></dd>

                <dt class="required">電話番号</dt>
                <dd><input type="text" pattern="^[0-9]*$" name="tell" class="info" required></dd>

                <div>
                    <button id="up">送信</button>
                </div>
            </dl>



        </form>

    </main>
    <footer>@高橋</footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script>
        const hogeArray = <?= json_encode($username) ?>;
        console.log(hogeArray);
        console.log(hogeArray[0][0].username);

        let username = document.getElementById("username");
        let namealert = document.getElementById("namealert");



        function inputName($this) {
            //console.log($this.value);
            const count = {
                ng: 0,
            };
            for (i = 0; i < hogeArray.length; i++) {
                if (hogeArray[i][0].username != ($this.value)) {
                    console.log("OK");
                } else {
                    console.log("重複");
                    count["ng"]++;
                }
            }

            console.log(count["ng"]);

            if (count["ng"] > 0) {
                namealert.style.display = 'inline-block';
                document.getElementById("up").disabled = true;
                document.getElementById("up").style.background = "#d0d0d0";
            } else if (count["ng"] === 0) {
                namealert.style.display = 'none';
                document.getElementById("up").disabled = false;
                document.getElementById("up").style.background = "#3cb371";
            }
        }

        let email = document.getElementById("email");
        let emailalert = document.getElementById("emailalert");


        function inputMail($this) {

            const count = {
                ng: 0,
            };
            for (i = 0; i < hogeArray.length; i++) {
                if (hogeArray[i][0].email != ($this.value)) {
                    console.log("OK");
                } else {
                    console.log("重複");
                    count["ng"]++;
                }
            }

            console.log(count["ng"]);

            if (count["ng"] > 0) {
                emailalert.style.display = 'inline-block';
                document.getElementById("up").disabled = true;
                document.getElementById("up").style.background = "#d0d0d0";
            } else if (count["ng"] === 0) {
                emailalert.style.display = 'none';
                document.getElementById("up").disabled = false;
                document.getElementById("up").style.background = "#3cb371";
            }


        }
    </script>

</body>

</html>