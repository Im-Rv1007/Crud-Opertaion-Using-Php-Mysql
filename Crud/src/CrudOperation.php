<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Mysql Crud Operation</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
        if(array_key_exists('insertData', $_POST)){
            insertDat();
        }
        if(array_key_exists("deleteData", $_POST)){
            deleteDat();
        }
        if(array_key_exists("updateData", $_POST)){
            updateda();
        }
        if(array_key_exists("updated", $_POST)){
            updatedData2();
        }

        function insertDat(){
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $myDB= "crudop";
            $flag=0;

            $conn = mysqli_connect($servername, $username, $password, $myDB);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $uname = $_POST['uName'];

            if (filter_var($_POST['uEmail'], FILTER_VALIDATE_EMAIL)) {
                $uemail = $_POST['uEmail'];
            } else {
                echo(" not a valid email address");
                $flag=$flag+1;
            }

            $sqlcheck ="select email from task";
            $resultcheck= mysqli_query($conn,$sqlcheck);
            while($rows = mysqli_fetch_assoc($resultcheck)){
                if($uemail==$rows["email"]){
                    echo "Enter Unique Email Address";
                    $flag=$flag+1;
                }
            }
            

            if(strlen($_POST['uNumber']>8)){
                $uphone = $_POST['uNumber'];
            }else{
                echo("not a valid Phone Number");
                $flag=$flag+1;
            }

            
            if(preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $_POST['uPassword'] )){
                $upasswd = $_POST['uPassword'];
                echo "Strong Password ";
            }else{
                echo(" not a valid password");
                $flag=$flag+1;
            }

            $uphone = $_POST['uNumber'];
            $uconfirmpasswd = $_POST['uConPassword'];
            
            if($upasswd==$uconfirmpasswd){
                if($flag==0){
                    $sql="INSERT INTO task(name,email,phone,password) VALUES('$uname','$uemail',$uphone,'$upasswd')";
                    if(mysqli_query($conn,$sql)){
                        $last_id = mysqli_insert_id($conn);
                        echo "data store with id : ".$last_id;
                    }
                    else{
                        echo "error ".$sql."<br/>".mysqli_error($conn)."<br>";
                    }
                }
                else{
                    echo "Enter Proper Data";
                }
            }else{
                echo 'Password and Confirm password Not match';
            }
            
            mysqli_close($conn);
        }
    
        function deleteDat(){
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $myDB= "crudop";
            $idd=$_POST['deleteData'];
            echo $idd;
            $conn = mysqli_connect($servername, $username, $password, $myDB);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "Delete from task where id=".$idd;

            if (mysqli_query($conn,$sql)){
                echo 'Record Deleted <br>';
            }else{
                echo "error ".mysqli_error($conn);
            }
        }
        function updatedData2(){
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $myDB= "crudop";

            $conn = mysqli_connect($servername, $username, $password, $myDB);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $uid = $_POST['updated'];
            $uname = $_POST['uName'];
            $uemail = $_POST['uEmail'];
            $uphone = $_POST['uNumber'];
            
            $sqlup = "UPDATE task SET name='$uname', email='$uemail', phone='$uphone' where id = $uid";
            
            if ($conn->query($sqlup) === TRUE) {
                echo "Record updated successfully <br>";
            } else {
                echo "Error updating record: " . $conn->error;
            }

            $conn->close();
        }
        function updateda(){
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $myDB= "crudop";
            $idud = $_POST['updateData'];


            $conn = mysqli_connect($servername, $username, $password, $myDB);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

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

            <?php   
            $conn->close();
        }
    ?> 
    <button type="submit" class="btn btn-primary"  data-toggle="modal" data-target="#newUser" style="margin:10px;"> + Add New User</button>
          
        <!--New Data Add -->
        <div class="modal fade" id="newUser" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>User Detail</h3>
                    </div>
                    <div class="modal-body">
                        <form method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="uName" class="form-control" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="email" name="uEmail" class="form-control" placeholder="Email" required>
                                    <span>@ and . required</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="number" name="uNumber" class="form-control" placeholder="Phone No." required>
                                    <span>Minimum 8 Digit required</span>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="password" name="uPassword" class="form-control" placeholder="Password" required >
                                    <span>Minimum 1 upperCase, 1 lowerCase , 1 numeric and Minimum length of 8 required</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <input type="password" name="uConPassword" class="form-control" placeholder="Confirm Password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="submit" name="insertData" class="btn btn-primary w-100" >
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <input type="reset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
            $servername = "localhost";
            $username = "root";
            $password = "root";
            $myDB= "crudop";
    
            $conn = mysqli_connect($servername, $username, $password, $myDB);
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql ="select * from task";
            $result= mysqli_query($conn,$sql); ?>
            <form method='post'>
            
            <table border=1 class='table table-striped'>
            <thead class=''>
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
            </thead>
            <tbody>
                <?php while($rows = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                    <?php $Rid=$rows["id"];?>
                    <td><?php echo $Rid ?></td>
                    <td><?php echo $rows["name"] ?></td>
                    <td><?php echo $rows["email"] ?></td>
                    <td><?php echo $rows["phone"] ?></td>
                    <td>
                    <button type='submit' name='deleteData' value='<?php echo $Rid ?>' class='btn btn-danger'>Drop</button>
                    <button type='submit' name='updateData' value='<?php echo $rows["id"] ?>' class='btn btn-info' data-toggle='modal' data-target='#updateUser'>Update</button>
                    </td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
            </form>
        <?php mysqli_close($conn);?>
</body>
</html>