<?php
namespace sqlcrud;

class update{
    function updatedData2(){
        include "dbConn.php";

        $uid = $_POST['updated'];
        $uname = $_POST['uName'];
        $flag=0;
        // $uemail = $_POST['uEmail'];

        if (filter_var($_POST['uEmail'], FILTER_VALIDATE_EMAIL)) {
            $uemail = $_POST['uEmail'];
        } else {
            echo "<br> not a valid email address";
            $flag=$flag+1;
        }
        
        if(strlen($_POST['uNumber']>8)){
            $uphone = $_POST['uNumber'];
        }else{
            echo "<br><p color='red'>not a valid Phone Number</p>";
            $flag=$flag+1;
        }

        $sqlcheck ="select email,phone from task except select email,phone from task where id=$uid";
        $resultcheck= mysqli_query($conn,$sqlcheck);
        while($rows = mysqli_fetch_assoc($resultcheck)){
            if($uemail==$rows["email"]){
                echo "<br>Enter Unique Email Address";
                $flag=$flag+1;
            }
            if($uphone==$rows["phone"]){
                echo "<br>Enter Unique Phone Number";
                $flag = $flag+1;
            }
        }

        if($flag==0){
            $sqlup = "UPDATE task SET name='$uname', email='$uemail', phone='$uphone' where id = $uid";
            
            if ($conn->query($sqlup) === TRUE) {
                echo "<br>Record updated successfully <br>";
            } else {
                echo "<br>Error updating record: " . $conn->error;
            }
        }else{
            echo '<br>data not added';
        }

        $conn->close();
    }
    function updateda(){
        include "dbConn.php";
        echo 'im here';
        $idud = $_POST['updateData'];
        $sqlup = "select * from task where id =  $idud";
        $resultup = mysqli_query($conn, $sqlup);

        while($row = mysqli_fetch_assoc($resultup)) {
            $nameu = $row["name"];
            $emailu=$row["email"];
            $phoneu= $row["phone"];
        }
        ?>
        
         <form method="post">
             <div class='row'>
                 <div class="col-lg-6">
                     <div class="form-group">
                         <input disabled type='text' name='id' value='<?php echo $idud; ?>' class='form-control' placeholder='id'>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="form-group">
                         <input type='text' name='uName' value='<?php echo $nameu; ?>' class='form-control' placeholder='Name'>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-lg-6">
                     <div class="form-group">
                         <input type='email' name='uEmail' value='<?php echo $emailu; ?>' class='form-control' placeholder='Email'>
                         <span>@ and . required</span>
                     </div>
                 </div>
                 <div class="col-lg-6">
                     <div class="form-group">
                         <input type='number' name='uNumber' value='<?php echo $phoneu; ?>' class='form-control' placeholder='Phone No.'>
                         <span>Minimum 8 Digit required</span>
                     </div>
                 </div>
             </div>
             <div class="row">
                 <div class="col-lg-2">
                     <div class="form-group">
                         <button type="submit" name='updated' value='<?php echo $idud; ?>' class="btn btn-success w-100" >Update</button>
                     </div>
                 </div>
             </div>
         </form>

    <?php  $conn->close();
    }    
}
?>