<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="signup.css">
</head>
<body>
<section>
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an account</h2>

              <form action="" method="post">

                <div class="form-outline mb-4">
                  <input type="text" id="name" class="form-control form-control-lg" name="name" required/>
                  <label class="form-label" for="name">Your Name</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="email" id="email" name="email" class="form-control form-control-lg" required/>
                  <label class="form-label" for="emial">Your Email</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="text" id="username" name="username" class="form-control form-control-lg" required/>
                  <label class="form-label" for="username">Username</label>
                </div>

                <div class="form-outline mb-4">
                  <input type="password" id="pas" name="pas" class="form-control form-control-lg" required/>
                  <label class="form-label" for="pas">Your password</label>
                </div>

                

                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>

                <p class="text-center text-muted mt-5 mb-0">Have already an account? <a href="login.php" class="fw-bold text-body"><u>Login here</u></a></p>

              </form>

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

$users=get_users_password("users.json");
$usernames=array_keys($users);


$emails=get_emails("emails.json");


if (count($_POST)>0){

    $flag=true;

    if (in_array($_POST["username"],$usernames)){
        $flag=false;
        echo '<script>
            alert("this username is existed")
        </script>';
    }

    $userpattern="/^[a-z A-Z 0-9 _]{3,32}$/";
    if (preg_match($userpattern,$_POST["username"])==false){
        $flag=false;
        echo '<script>
            alert("username is not valid")
        </script>';
    }


    if (in_array($_POST["email"],$emails)){
        $flag=false;
        echo '<script>
            alert("this email is existed")
        </script>';
    }     

    $emailpattern="/^\w+([\.-]?\w+)*@([a-z]|[A-Z])+\.[a-z]{2,3}$/";
    if (preg_match($emailpattern,$_POST["email"])==false){
        $flag=false;
        echo '<script>
            alert("email is not valid")
        </script>';
    }    

    
    $namepattern="/^[a-z A-Z \s]{3,32}$/";
    if (preg_match($namepattern,$_POST["name"])==false){
        $flag=false;
        echo '<script>
            alert("name is not valid")
        </script>';
    }
    

    $paspattern="/^.{4,32}$/";
    if (preg_match($paspattern,$_POST["pas"])==false){
        $flag=false;
        echo '<script>
            alert("password is not valid")
        </script>';
    }


    if ($flag==true){


        $ar=[
            $_POST["username"] =>
                [
                    "pas"=>$_POST["pas"],
                    "email"=>$_POST["email"],
                    "name"=>$_POST["name"],
                    "profile"=>$_POST["username"]
                ]
            ];
        

        $users=array_merge($users,$ar);
        $obj=json_encode($users);
        file_put_contents("users.json",$obj);


        array_push($emails,$_POST["email"]);
        $json_emails=json_encode($emails);
        file_put_contents("emails.json",$json_emails);


        foreach ($_POST as $key => $value) {
            setcookie($key,$value,time()+8600);
        }
        setcookie("profilename",$_POST["username"],time()+8600);



        header("location: chatroom.php");
    }
}
?>