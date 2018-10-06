

<?php
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

$sql = "CREATE TABLE mission4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,"
."name char(32),"
."comment TEXT,"
."today DATETIME,"
."password TEXT"
.");";
$stmt = $pdo->query($sql);


if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["password1"])){
	$sql = $pdo -> prepare("INSERT INTO mission4(name,comment,today,password) VALUES(:name,:comment,now(),:password)");
	$sql -> bindParam(':name' , $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment' , $comment, PDO::PARAM_STR);
	$sql -> bindParam(':password',$pass,PDO::PARAM_STR);
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$pass=$_POST["password1"];
	$sql -> execute();
}

if(!empty($_POST["delete"])){
	$id=$_POST["delete"];
	$number_delete=$_POST["password2"];
	$sql="delete from mission4 where id='$id' AND password='$number_delete' ";
	$result=$pdo->query($sql);
	
}

if(!empty($_POST["delete"])){
	$id=$_POST["delete"];
	$number_delete=$_POST["password2"];
	$sql="select * from mission4 where id='$id' ";
	$result=$pdo->query($sql);
	foreach($result as $row){
		if($number_delete!=$row['password']){
			echo"パスワードが違います";
		}
	}
}


if(!empty($_POST["edit"])){
	$id=$_POST["edit"];
	$number_edit=$_POST["password3"];
	$sql="select * from mission4 where id=$id";
	$result=$pdo->query($sql);
	foreach($result as $row){
		if($number_edit==$row['password']){
			$edit_name=$row['name'];
			$edit_comment=$row['comment'];
			$num_edit=$row['id'];
		}else{
			echo"パスワードが違います";
		}
	}
}




if(!empty($_POST["edit2"])){
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$hidden_edit=$_POST["edit2"];
	$sql = $pdo -> prepare("update mission4 SET name=:name , comment=:comment , today=now() where id=:hidden_edit");
	$sql -> bindParam(':name' , $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment' , $comment, PDO::PARAM_STR);
	$sql -> bindParam(':hidden_edit', $hidden_edit, PDO::PARAM_STR);
	$sql -> execute();
}
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>mission4</title>
</head>
<body>
<form method="POST" action="mission_4.php">
<input type = 'text' name ='name' placeholder = '名前' value = "<?php echo $edit_name;?>"><br>
<input type='text' name='comment' placeholder = 'コメント' value = "<?php echo $edit_comment;?>"><br>
<input type='text' name='password1' placeholder = 'パスワード' >
<input type='hidden' name='edit2' value="<?php echo $num_edit;?>">
<input type='submit' value='送信'><br>
<p><input type='text' name='delete' placeholder='削除対象番号'><br>
<input type='text' name='password2' placeholder='パスワード'>
<input type='submit' value='削除'><br>
<p><input type='text' name='edit' placeholder='編集対象番号'><br>
<input type='text' name='password3' placeholder='パスワード'>
<input type='submit' value='編集'><br>
</form>

<?php
$sql = "SELECT*FROM mission4 order by id";
$results = $pdo -> query($sql);
foreach ($results as $row){
echo $row['id']." ".$row['name']." ".$row['comment']." ".$row['today'].'<br>';
}
?>

</body>
</html>
