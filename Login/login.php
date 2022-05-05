<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <section class=" gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <div class="mb-md-5 mt-md-4 pb-5">

                                <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                <p class="text-white-50 mb-5">Please enter your login and password!</p>
                                <form action="" method="post">
                                    <div class="form-outline form-white mb-4">
                                        <input type="text" id="username" name="username" class="form-control form-control-lg" required value=<?php if(count($_COOKIE)>0){
                                            echo $_COOKIE["username"];}
                                            else{
                                                echo "";
                                            }
                                            ?>>
                                        <label class="form-label" for="username">Username</label>
                                    </div>

                                    <div class="form-outline form-white mb-4">
                                        <input type="password" id="typePasswordX" name="pas" class="form-control form-control-lg" required value=<?php if(count($_COOKIE)>0){
                                            echo $_COOKIE["pas"];}
                                            else{
                                                echo "";}
                                            ?> >
                                        <label class="form-label" for="typePasswordX">Password</label>
                                    </div>

                                    

                                    <button class="btn btn-outline-light btn-lg px-5 " type="submit">Login</button>

                                </form>

                            </div>

                            <div>
                                <p class="mb-0">Don't have an account? <a href="signup.php" class="text-white-50 fw-bold">Sign Up</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>

<?php
include "functions.php";

$users=get_users_passwords();
$usernames=get_userNames();
$profiles = get_profile_name();

if (count($_POST)>0){

    if (in_array($_POST["username"],$usernames)){

        if ($_POST["pas"]!=$users[$_POST["username"]]){
            echo '<script>
                    alert("password isn\'t match with username")
                </script>';
        }
        
        else{
            setcookie("username",$_POST["username"],time()+8600);
            setcookie("pas",$_POST["pas"],time()+8600);
            setcookie("profilename",$profiles["username"],time()+8600);
            header("location: chatroom.php");
        }

    }
    else{
        echo '<script>
                    alert("username isn\'t exist")
                </script>';
    }

}
?>
