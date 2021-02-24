<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stylesheet.css">
    <title>mission_5</title>
</head>
<body>
        
    
<?php
    //空データによるエラーを表示しない
    error_reporting(E_ALL & ~E_NOTICE);
    
    
    //データベースの作成
    
    $pdo = new PDO ($dsn,$user,$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    $pass = $_POST["pass"];
    $edit_num = $_POST["edit_num"];
    
    $sql = "CREATE table if not exists table_go"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."date datetime,"
    ."pass char(32)"
    .");";
    $stmt = $pdo->query($sql);
    
    if(!empty($edit_num) && !empty($pass)== true){
        $sql = "SELECT * from table_go where id ='$edit_num';";
        $results = $pdo -> query($sql);
        foreach($results as $editdate){
        if($pass == $editdate[4]){
        $edit_num = $editdate[0];
        $edit_name = $editdate[1];
        $edit_come = $editdate[2];
        $edit_pass = $editdate[4];
        }
        }
    }
?>

    <form action="" method = "post" class = "aaa">
    <p><input type = "text" name = "edit_mode" value=<?php echo $edit_num?>></p>
    
    <p>
        <input type="text" name="name" placeholder= "名前" value=<?php echo $edit_name?>>
        <input  type="text" name="come" placeholder= "コメント" value=<?php echo $edit_come?>>
    </p>
    <p>
        <input type = "text" name = "pass" placeholder = "パスワード" value=<?php echo $edit_pass?>>
    </p>
    <p>
        <input type="submit" name="submit">
    </p>
    </form>
    
    
    <form action="" method = "post">
        <p><input type="text" name="delnum" placeholder= "削除番号"></p>
        <p><input type = "text" name = "pass" placeholder = "パスワード"></p>
        <input type="submit" name="btn" value ="削除">
    </form>
    
    
    <form action="" method = "post" >
        <p><input type="text" name="edit_num" placeholder= "編集番号"></p>
        <p><input type = "text" name = "pass" placeholder = "パスワード"></p>
        <input type="submit" name="btn" value ="編集">
    </form>
    
    
</div>


<?php
    
    $name = $_POST["name"];
    $come = $_POST["come"];
    $pass = $_POST["pass"];
    $date = date("Y/m/d h:m:s");
    $edit_mode = $_POST["edit_mode"];
    $del_num = $_POST["delnum"];
    
    if(!empty($name && $come) && empty($edit_mode) && !empty($pass) == true){
        /*データを入力（データレコードの挿入）*//**/

        $sql = $pdo -> prepare("INSERT into table_go(name,comment,date,pass) value(:name,:comment,:date,:pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
        
        $comment = $come;
        $password = $pass;
        $sql -> execute();
    }elseif(!empty($edit_mode)){
        $id = $edit_mode;
        $name = $name;
        $comment = $come;
        //$date = ;
        $pass = $pass;//変更内容の指定
        //UPDATE テーブル名 SET カラム名 = 値 WHERE 条件;
        $sql = "UPDATE table_go SET id=:id, name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id2";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);        
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':id2', $edit_mode, PDO::PARAM_INT);
        $stmt->execute();
        
    }
    
    if(!empty($_POST["delnum"])) {
        //データベース内容の破棄
    $sql = "SELECT pass FROM table_go where id = '$del_num';";
    $results = $pdo->query($sql);
    foreach ($results as $row){
        $flag = $row[0];
    }
    if($flag == $pass){
        //DELETE FROM テーブル名 WHERE 条件;
        $sql = "DELETE from table_go WHERE id = '$del_num';";
        $stmt = $pdo ->query($sql);
    }
        
    }
    
    
    
    $sql = 'SELECT * FROM table_go';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
    
    echo "<b>".$row['id']."</b>".',';
    echo $row['name']."<br>";
    echo $row["date"]."<br>";  
    echo $row['comment']."<br>";
    echo $row['pass']."<br>";
    echo "<br>"."</div>";  
}


?>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
</body>
</html>