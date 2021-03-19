<?php
namespace sqlcrud;

class insert{
    function insertDat(){
        include "dbConn.php";
        $flag=0;

        $uname = $_POST['uName'];

        if (filter_var($_POST['uEmail'], FILTER_VALIDATE_EMAIL)) {
            $uemail = $_POST['uEmail'];
        } else {
            echo"<br> not a valid email address";
            $flag=$flag+1;
        }

        if(strlen($_POST['uNumber']>8)){
            $uphone = $_POST['uNumber'];
        }else{
            echo "<br>not a valid Phone Number";
            $flag=$flag+1;
        }

        
        $sqlcheck ="select email, phone from task";

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
        // $user_check_query = "SELECT * FROM task WHERE email='$uemail' OR phone='$uphone' LIMIT 1";
        // $result = mysqli_query($conn,$user_check_query);
        // $user = mysqli_fetch_assoc($result);
        // print_r($user['email']);
        // if ($user) { // if user exists
        //     if ($user['phone'] === $uphone) {
        //         echo "Phone Number already exists";
        //         $flag=$flag+1;
    
        //     }

        // if ($user['email'] === $uemail) {
        //     echo "email already exists";
        //     $flag=$flag+1;
        // }
        // }





      









        
        if(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['uPassword'] )){
            $upasswd = $_POST['uPassword'];
        }else{
            echo "<br> not a valid password";
            $flag=$flag+1;
        }

        $uconfirmpasswd = $_POST['uConPassword'];
        
        if($upasswd==$uconfirmpasswd){
            if($flag==0 ){
                $password1=md5($upasswd);
                $sql="INSERT INTO task(name,email,phone,password) VALUES('$uname','$uemail',$uphone,'$password1')";
                if(mysqli_query($conn,$sql)){
                    $last_id = mysqli_insert_id($conn);
                    echo "<br>data store with id : ".$last_id;
                }
                else{
                    echo "<br>error ".$sql."<br/>".mysqli_error($conn);
                }
            }
            else{
                echo "<br>Enter Proper Data";
            }
        }else{
            echo '<br>Password and Confirm password Not match';
        }
        
        mysqli_close($conn);
    }
}

?>