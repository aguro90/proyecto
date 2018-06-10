<?php
session_start();
require 'connections/connection2.php';
require 'security/security1.php';
if(!isset($_REQUEST['id_account'])) {
		            	header("location:logout.php");
}
echo $_SESSION['user_id'];echo "<br>";
echo $_REQUEST['id_account'];echo "<br>";
    $stmt = $con2->prepare("SELECT id_account,screen_name FROM accounts WHERE id_account=? AND user_id=? ;");
    $stmt->bind_param('si', $_REQUEST['id_account'], $_SESSION['user_id']);
    $stmt->execute();
    $stmt->bind_result($id_account,$screen_name);
    $stmt->store_result();
	echo $stmt->num_rows;
  	if($stmt->num_rows == 1)  //To check if the row exists
        {
            if($stmt->fetch()) //fetching the contents of the row
            {
						mysqli_query($con2,"delete from accounts where id_account=".$_REQUEST['id_account']."");
						echo "<script type=\"text/javascript\"> myerror(); </script>";
						$con2->commit();
						header("location:cuentas.php");
            	}
            	}else {
	            	header("location:logout.php");
            		}
?>
<html>
<head>
<title>Eliminar Cuenta</title>
<script>
function myerror() {
    alert("Borrado correctamente...");
}
</script>
</head>
</html>
</html>