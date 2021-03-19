<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud Operation</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">    
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
    <?php 
        require "vendor/autoload.php";
        use sqlcrud\insert;
        use sqlcrud\delete;
        use sqlcrud\update;

        if(array_key_exists('insertData', $_POST)){
            $val=new insert();
            $val -> insertDat();
        }
        if(array_key_exists("deleteData", $_POST)){
            $val1 =new delete();
            $val1 -> deleteDat();
        }
        if(array_key_exists("updateData", $_POST)){
            $val2 = new update();
            $val2 -> updateda();
        }
        if(array_key_exists("updated", $_POST)){
            $val3 = new update();
            $val3 -> updatedData2();
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

        <!--Data show on page -->
        <?php
        include "dbConn.php";
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
                    <button type="submit" name='updateData' value='<?php echo $rows["id"] ?>' class='btn btn-info'>Update</button>
                    </td>
                    </tr>
                <?php } ?>
            </tbody>
            </table>
            </form>
        <?php mysqli_close($conn);?>
</body>
</html>