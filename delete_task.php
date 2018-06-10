<?php
session_start();
require 'connections/connection2.php';
require 'security/security1.php';
if(!isset($_REQUEST['id_task'])) {
		            	header("location:logout.php");
}
echo $_REQUEST['id_task'];
#echo $_SESSION['user_id'];echo "<br>";
#echo $_REQUEST['id_account'];echo "<br>";
$sql="SELECT tasks.id_task FROM tasks,accounts 
    WHERE tasks.id_task = ? and tasks.id_account=accounts.id_account and accounts.user_id = ".$_SESSION['user_id']."";
    #WHERE tasks.id_task = 6 and tasks.id_account=accounts.id_account and accounts.user_id=1
    $stmt = $con2->prepare($sql);
    $stmt->bind_param('i', $_REQUEST['id_task']);
    $stmt->execute();
     printf("Error: %s.\n", $stmt->error);
    $stmt->bind_result($id_task);
    $stmt->store_result();
	echo $stmt->num_rows;
  	if($stmt->num_rows == 1)  //To check if the row exists
        {
            if($stmt->fetch()) //fetching the contents of the row
            {
						mysqli_query($con2,"delete from tasks where id_task=".$_REQUEST['id_task']);
						$con2->commit();
						header("location:tasks.php");
            	}
            	}else {
	            	header("location:logout.php");
            		}
?>