<?php
//env利用
//require './vendor/autoload.php';
//Dotenv\Dotenv::createImmutable(__DIR__)->load();

//session_start();
//include("functions.php");
//check_customer_session_id();

//mb_language("Japanese"); //文字コードの設定
//mb_internal_encoding("UTF-8");

$address = $detail["adress"];
$apikey = getenv('YAHOO_MAP_KEY');
$address = urlencode($address);
$url = "https://map.yahooapis.jp/geocode/V1/geoCoder?output=json&recursive=true&appid=" . $apikey . "&query=" . $address;
$contents = file_get_contents($url);
$contents = json_decode($contents);
$Coordinates = $contents->Feature[0]->Geometry->Coordinates;
$geo = explode(",", $Coordinates);
$lon = $geo[0];
$lat = $geo[1];
//echo "緯度：" . $lat . " 経度：" . $lon;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="icon" href="img/favicon.ico"> <!-- ファビコンを設定 -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/favicon.ico"> <!-- アップルタッチアイコンも設定 -->
    <link rel="stylesheet" href="css/store_detail.css">
    <style>
        #map-canvas {
            width: 100%;
            height: 300px;
        }
    </style>
    <title>たまりbar</title>
</head>

<body>



    <header>
        <div class="header__wrapper">
            <div>
                <h1 class="tamari_family">たまりbar</h1>
                <p class="tamari_family">移住者のコミュニティーが生まれる</p>
                <p>ユーザー名:<?= $_SESSION['username']; ?></p>
            </div>

            <ul class="nav__list">
                <li class="nav-item"><a href="store_read.php">店舗一覧に戻る</a></li>
                <li class="nav-item"><a href="index.php">トップに戻る</a></li>
                <li class="nav-item"><a href="customer_logout.php">ログアウトする</a></li>
                <li class="nav-item"><a href="customer_register_edit.php?id=<?= $_SESSION['id']; ?>">ユーザー情報の編集</a></li>
            </ul>

        </div>
    </header>

    <h2 class="tamari_family">店舗情報の詳細</h2>

    <main>
        <h1><?php echo $detail['name'] ?></h1>
        <img src="<?= $detail['filesurl']; ?>" width="auto" height="300">
        <ul class="detail">
            <li>
                <h3>詳細情報</h3>
            </li>
            <li>
                <p>お店のジャンル：<span class="bold"><?php echo $detail["category"]; ?></span></p>
            </li>
            <li>
                <p>客層：<span class="bold"><?php echo $detail["moodselect"]; ?></span></p>
            </li>
            <li>
                <p>雰囲気：<span class="bold"><?php echo $detail["moodtext"]; ?></span></p>
            </li>
            <li>
                <p>料理・飲み物：<span class="bold"><?php echo $detail["foodtext"]; ?></span></p>
            </li>
            <li>
                <p>店のメッセージ：<span class="bold"><?php echo $detail["message"]; ?></span></p>
            </li>
            <li>
                <p>予算：<span class="bold"><?php echo $detail["budget"]; ?></span></p>
            </li>
            <li>
                <p>住所：<span class="bold">〒<span class="mgr-100"><?php echo $detail["postadress"]; ?></span><?php echo $detail["adress"]; ?></span></p>
            </li>
            <li>
                <p>電話：<span class="bold"><?php echo $detail["tell"]; ?></span></p>
            </li>
            <li>
                <p>開業日：<span class="bold"><?php echo $detail["openday"]; ?></span></p>
            </li>

        </ul>
        <h1>アクセス</h1>
        <div id="map-canvas"></div>

        <div class="buttonli">
            <div>
                <p><a href="reserve.php?store=<?php echo $detail['name'] ?>" class="button">予約する</a></p>
            </div>
        </div>
        <div class="buttonli">
            <div>
                <p><a href="store_read.php" class="button">リストに戻る</a></p>
            </div>
        </div>


    </main>


    <script src="https://maps.googleapis.com/maps/api/js?key=<?= getenv('GOOGLE_MAP_KEY'); ?>"></script>
    <script>
        const keido = <?= json_encode($lon) ?>;
        console.log(keido);
        const ido = <?= json_encode($lat) ?>;
        console.log(ido);

        function makeMap(lat, lng) {
            var canvas = document.getElementById('map-canvas'); // 地図を表示する要素を取得

            var latlng = new google.maps.LatLng(lat, lng); // 中心の位置（緯度、経度）

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
            });

            var mapOptions = { // マップのオプション
                zoom: 17,
                center: latlng,
            };

            var map = new google.maps.Map(canvas, mapOptions); //作成
            //return map;

            //ピン建てる
            var markerOptions = {
                map: map,
                position: latlng,
            };
            var marker = new google.maps.Marker(markerOptions);
        }

        //ページのロードが完了したら地図を読み込む
        window.onload = function() {
            makeMap(ido, keido);
        };
    </script>
</body>

</html>