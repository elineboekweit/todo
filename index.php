  <?php
 	$con = mysqli_connect("localhost","boekweit_admin","JN97vvXXoo","boekweit_database");
	//$con = mysqli_connect("localhost","root","","todo");

	require '../testip.php';
 	require '../HackBlock.php';
 	
 	$hour = date ("H:i");
	$timezone = date("d M Y");

 	$string = isset($_POST['list']) ? $_POST['list'] : null;
    $codeblock = strip_tags($string);

    $update = isset($_POST['rewrite']) ? $_POST['rewrite'] : null;
    $codeupdate = strip_tags($update);

	if (mysqli_connect_errno()) {	
	   echo "Failed to connect to MySQL";
	   }

 	if (isset($_GET['delete']) and isset($_GET['id'])) {
 		$delete = $_GET['delete'];
		$id = $_GET['id'];
	} else {
		$delete = '';
		$id = '';
	}

	if ($delete == "true"){
		mysqli_query($con, "DELETE FROM activiteiten WHERE id = '$id'");
	}
		
	if (isset($_POST['list'])) {
		
		$sql = "INSERT INTO activiteiten (omschrijving, ip, datum, hour) VALUES ('$codeblock', '$MyipAddress','$timezone', '$hour')";
		$result = mysqli_query($con, $sql);

		$value = $_POST['list'];
		setcookie("gaben.tv", $value, time()+63158399);
	}

	if (isset($_GET['update']) and isset($_GET['id'])) {
		$update = $_GET['update'];
		$id = $_GET['id'];
	} else {
		$update = '';
		$id = '';
	}

	if (isset($_POST['rewrite']) ) { //and $update == "true"

		$sql = "UPDATE activiteiten SET omschrijving = '$codeupdate' WHERE id = '$_POST[id]'";
		$result = mysqli_query($con, $sql);

		$value = $_POST['rewrite'];
		setcookie("gaben.sexy", $value, time()+63158399);
	}
	$sql = "SELECT id, omschrijving FROM activiteiten";
	$result = mysqli_query($con, $sql);
	$output = mysqli_fetch_all($result);
?>

<!DOCTYPE html>
<html>
<head>
	<title>les 3</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="icon" href="todolist.png">
	
</head>
<body>
	<div id="container">
	<header><!-- image voor todo --></header>
	<div class="content">
	<a id="pijl" href="../links/links.php"><img src="../images/pijl.png"></a>
		<table>
		<form method="post" action="index.php">
			<th><input type="text" name="list" placeholder="vul hier in"></th>
			<th><input type="submit" value=" Add "></th>
		</form>
		<?php foreach ($output as $data) { ?>
		<tr>
<?php if ($data['0'] == $id ) { ?>
			<td>
				<form method="post" action="index.php">
					<input type="text" name="rewrite" placeholder="<?=$data['1']?>">
					<input type="hidden" name="id" value="<?=$id?>">
				</form>
			</td>
<?php } else { ?>
			<td><?php echo xss_clean($data['1']);?></td>
<?php } ?>
		
			<td><a href='index.php?update=true&id=<?=$data['0']?>'><button><i class="fa fa-pencil"></i></button></a><br></td>
			<td><a href='index.php?delete=true&id=<?=$data['0']?>'><button><i class="fa fa-trash"></i></button></a><br></td>
		
		</tr>
<?php } ?>
		</table>
	</div>
	<?php require "footer.php"; ?>
	</div>
</body>
</html>



