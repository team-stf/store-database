
<!doctype html>


<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Google.com</title>
        <style>
			body {
				padding-top: 50px;
				background-color: lightgray;
			}

			.starter-template {
				padding: 40px 15px;
				background-color: white;
			}
			.sss{
				size: 50%;
			}
        </style>
    </head>

	

	<body>	
    <div class="container">			
			<div class="jumbotron">
				<h1>
					データベーステスト登録
				</h1>


<?php
if(isset($_POST["barcode"])) {
if (isset($_POST["content"])) {
                //画像アップロード

    //一字ファイルができているか（アップロードされているか）チェック
    if(is_uploaded_file($_FILES['up_file']['tmp_name'])){
        $extension = getExt($_FILES['up_file']['name']);
        $content = $_POST["content"];
        $barcode = $_POST["barcode"];

        //一字ファイルを保存ファイルにコピーできたか
        if(move_uploaded_file($_FILES['up_file']['tmp_name'],"../../img/".$barcode.".".$extension)){

            //正常
            $error = 0;
            $imgurl = $barcode.".".$extension;
            //echo $imgurl;
            echo "<p>画像アップロードしました。<div>";
        }else{

            //コピーに失敗
            echo "error while saving.";
            $error = 1;
        }

    }else{

        //そもそもファイルが来ていない。
        echo "file not uploaded.";
        $error = 2;

    }
    //echo $_FILES['up_file']['name'];
    }else{
        echo('OK,NO');
    }
}else{
    echo('no');
}

if($error==0){
    try {
        $dsn = 'mysql:dbname=store;host=localhost;charset=utf8mb4';
        $username ='store';
        $password = 'vGciFPmVGTdd86R682U75MfNdzAQMg';
    
        $pdo = new PDO($dsn, $username, $password);
        // 入力した値をデータベースへ登録
        } catch (PDOException $e) {
        // 接続できなかったらエラー表示
        echo 'DB接続エラー！: ' . $e->getMessage();
        }



        try{
            $stmt = $pdo->prepare('INSERT INTO product_contents (itemname, barnum, imgurl, created_at, updated_at) VALUES(:itemname, :barnum, :imgurl, NOW(), NOW() )');
 
            // 値をセット
            $stmt->bindValue(':itemname', $content);
            $stmt->bindValue(':barnum', $barcode);
            $stmt->bindValue(':imgurl', $imgurl);
            // $stmt->bindValue(':created_at', '22');
         
            // SQL実行
            $stmt->execute();
            echo('データベース追加しました。');
            //echo $barcode;
            //echo $content;
        } catch (PDOException $e) {
            // 接続できなかったらエラー表示
            echo 'error: ' . $e->getMessage();
            }

            //ここまで
            
            // $sql  = "INSERT INTO bbs (content, updated_at) VALUES (:content, NOW());";
            // $stmt = $pdo->prepare($sql);
            // //インジェクション対策
            // $stmt -> bindValue(":content", $content, PDO::PARAM_STR);
            // $stmt -> execute();

            //ファイル名から拡張子を取得する関数
        }
function getExt($filename)
{
	return pathinfo($filename, PATHINFO_EXTENSION);
}

?>
		<?php if($error==0) { ?>
            <h2>name : <?php echo $content ?><h2>
            <h2>barcode : <?php echo $barcode ?><h2>
            <h3>ファイル名 : <?php echo $_FILES['up_file']['name'];?></h3>
            
            <a href="<?php echo("https://store-project.f5.si/img/".$imgurl); ?>" class="btn btn-primary btn-lg">開く</a>
         <?php } ?>

					<div class="text-right">
					<input name="" type="submit" class="btn btn-primary btn-lg">

					</div>
				</form>
			</div>
		</div>		
	</body>
</html>