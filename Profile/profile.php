<?php
include "functions.php";

$users=get_users_password("users.json");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="profile.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-dark d-flex justify-content-center">
    
    <div class="w-50 procard d-flex flex-column align-items-center gap-2 pt-3">
 
        <?php if (isset($users[$_COOKIE["prouser"]]["proimg"])){?>
            <div class="">
                <a href="<?php echo $users[$_COOKIE["prouser"]]["proimg"] ?>" target="_blank" rel="noopener noreferrer"><img class="img-fluid imagee" src="<?php echo $users[$_COOKIE["prouser"]]["proimg"] ?>" ></a>
            </div>
        <?php
            }
            else{?>

            <div class="image fontprofile"><?php echo strtoupper($users[$_COOKIE["prouser"]]["profile"][0]) ?></div>
                            
        <?php
            }?>

        <div>
            <span class="display-6 text-danger">Profile name:</span>
            <span class="display-6 text-success"><?php echo $users[$_COOKIE["prouser"]]["profile"] ?></span>
        </div>

        <div>
            <span class="display-6 text-danger">Name:</span>
            <span class="display-6 text-success"><?php echo $users[$_COOKIE["prouser"]]["name"] ?></span>
        </div>

        <?php
            
            array_pop($_COOKIE);
            setcookie("prouser","",time()-1);
            

        ?>

        <a href="http://localhost/php/hw7/chatroom.php">Back→</a>

    </div>        

    

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>
