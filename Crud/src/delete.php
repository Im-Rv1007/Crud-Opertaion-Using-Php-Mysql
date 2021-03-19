<?php
namespace sqlcrud;
class delete{
    function deleteDat(){
        include "dbConn.php";
        
        $idd=$_POST['deleteData'];
        echo $idd;
        
        $sql = "Delete from task where id=".$idd;

        if (mysqli_query($conn,$sql)){
            echo '<br>Record Deleted <br>';
        }else{
            echo "<br>error ".mysqli_error($conn);
        }
    }
}
?>