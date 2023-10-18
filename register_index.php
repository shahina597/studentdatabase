<?php
	include 'admin_dbcon.php';
	if(isset($_POST['register'])){
		$username=$_POST['username'];
		$email=$_POST['email'];
		$mobile=$_POST['mobile'];
		$password=$_POST['password'];
		$c_password=$_POST['c_password'];
        $input_error=array();
        if(empty($username)){
            $input_error['username']="Username is required";
        }
        if(empty($email)){
            $input_error['email']="Email is required";
        }
        if(empty($mobile)){
            $input_error['mobile']="Mobile is required";
        }
        if(empty($password)){
            $input_error['password']="Password is required";
        }
        if(empty($c_password)){
            $input_error['c_password']="Confirm Password is required";
        }
        if(count($input_error)==0){
            if(strlen($username)>=5){
                if(strlen($password)>=8 && strlen($c_password)>=8){
                        if($password==$c_password){
                                $user_check=mysqli_query($db_con,"SELECT * FROM `admin_users` WHERE `username`='$username'");
                                if(mysqli_num_rows($user_check)==0){
                                    $email_check=mysqli_query($db_con,"SELECT * FROM `admin_users` WHERE `email`='$email'");     
                                        if(mysqli_num_rows($email_check)==0){
                                                $password=md5($password);
                                                date_default_timezone_set("Asia/Dhaka");
                                                $reg_time=date('m-d-Y,h:i:s a');
                                            $insert_query=mysqli_query($db_con,"INSERT INTO `admin_users`(`username`, `email`, `mobile`, `password`, `reg_time`, `status`) VALUES ('$username','$email','$mobile','$password','$reg_time','Inactive')");
                                                if($insert_query){
                                                    echo '<script>
                                                    alert("Successfully registered");
                                                    window.location.href="register_index";
                                                    </script>
                                                    ';
                                                    $username=false;
                                                    $email=false;
                                                    $mobile=false;
                                                    $password=false;
                                                  
                                                }

                                        }else{
                                            $input_error['email_unique']="This email is already exit";
                                        }
                                }else{
                                    $input_error['username_unique']="This username is already exit";
                                }

                        }else{
                            $input_error['dont_match']="Confirm password do not match";
                        }



                }else{
                    $input_error['password_length']="Password field must be 8 character";
                }



            }else{
                $input_error['strlen']="Username must be 5 character";
            }


        }
      



		
	}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register-Future Computer Training Institute</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <div class="container">
        <h1>Admin Register System</h1>
        <form action="" method="POST">
            <div class="input-group">
                <label for="">Username:</label>
                <input type="text" name="username" id="" value="<?php if(isset($username)){echo $username;}?>">
                <span class="error"><?php if(isset($input_error['username'])){echo $input_error['username'];}?></span>
                <span class="error"><?php if(isset($input_error['strlen'])){echo $input_error['strlen'];}?></span>
                <span class="error"><?php if(isset($input_error['username_unique'])){echo $input_error['username_unique'];}?></span>
            </div>
            <div class="input-group">
                <label for="">Email:</label>
                <input type="email" name="email" id="" value="<?php if(isset($email)){echo $email;}?>">
                <span class="error"><?php if(isset($input_error['email'])){echo $input_error['email'];}?></span>
                <span class="error"><?php if(isset($input_error['email_unique'])){echo $input_error['email_unique'];}?></span>
            </div>
            <div class="input-group">
                <label for="">Mobile:</label>
                <input type="tel" name="mobile" id="" pattern="01[1|3|4|9|7|8|6|5][0-9]{8}" value="<?php if(isset($mobile)){echo $mobile;}?>">
                <span class="error"><?php if(isset($input_error['mobile'])){echo $input_error['mobile'];}?></span>
            </div>
            <div class="input-group">
                <label for="">Password:</label>
                <input type="password" name="password" id="password" value="<?php if(isset($password)){echo $password;}?>" >
                <span class="error"><?php if(isset($input_error['password'])){echo $input_error['password'];}?></span>
                <span class="error"><?php if(isset( $input_error['password_length'])){echo  $input_error['password_length'];}?></span>
            </div>
            <div class="input-group">
                <label for="">Confirm Password:</label>
                <input type="password" name="c_password" id="c_password" value="<?php if(isset($c_password)){echo $c_password;}?>" >
                <span class="error"><?php if(isset($input_error['c_password'])){echo $input_error['c_password'];}?></span>
                <span class="error"><?php if(isset($input_error['dont_match'])){echo $input_error['dont_match'];}?></span>
                
            </div>
        
          <button type="submit" name="register">Register</button>

        </form>

    </div>
    <script src="apps.js"></script>
</body>
</html>