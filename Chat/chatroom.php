<?php 


if(isset($_COOKIE["prouser"])){
                
    header("location: profile.php");

}

include "functions.php";

if (isset($_POST["block"]))
    block($_POST["block"]);
if (isset($_POST["unblock"]))
    unblock($_POST["unblock"]);

$blockusers=get_block_users();

rename_profile();
upload_new_iamge_profile();


$users=get_users_passwords();
$proimgs = get_profile_image();
$pronames = get_profile_name();

if (!isset($_COOKIE["username"]) || !isset($_COOKIE["pas"]))
        header("location: login.php");

else{
    if (!isset($users[$_COOKIE["username"]])){
        foreach ($_COOKIE as $key => $value) {
        setcookie($key,$value,time()-1);            
        }

        header("location: login.php");
    }    
}


if (isset($_COOKIE["deleted_msg"]))
    delete_message();

if (isset($_COOKIE["edited_msg"]) && isset($_COOKIE["num_msg"]))
    edit_message();
    

send_message();

?>


<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"  integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="chatroom.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>
  <body class="d-flex flex-column justify-content-center align-items-center" style="background-color:darkseagreen;">
    
    <div class="head">Chat Room</div>


    <button class="btn btset" type="button" data-bs-toggle="modal" data-bs-target="#settings">
        <i class="bi bi-gear"></i>
            </button>
            <div class="modal fade" id="settings" tabindex="-1" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Your profile</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body d-flex flex-column align-items-center gap-3">
                            <?php if (isset($proimgs[$_COOKIE["username"]])){?>
                            <div class="">
                                <a href="<?php echo $proimgs[$_COOKIE["username"]] ?>" target="_blank" rel="noopener noreferrer"><img class="img-fluid imagee" src="<?php echo $proimgs[$_COOKIE["username"]] ?>" ></a>
                            </div>
                            <?php
                            }
                            else{?>

                            <div class="image "><?php echo strtoupper($pronames[$_COOKIE["username"]][0]) ?></div>
                            
                            <?php
                            }?>


                            <div class="d-flex gap-2">

                                <span class="text-danger">Profile Name:</span>
                                <span><?php echo $pronames[$_COOKIE["username"]] ?></span>
                                
                            </div>

                                <form action="" method="post">
                                    <div class="d-flex gap-2">
                                        <input type="text" class="form-control " name="changepro" placeholder="Change your profile name">
                                        <input type="submit" class="btn btn-success " name="rename">
                                    </div>
                                </form>

                                <form action="" method="post" enctype="multipart/form-data">

                                    <div class="">
                                        
                                        <label for="select-image" class="form-label">Upload new image for your profile</label>
                                        <input class="form-control" name="proimg" type="file" id="select-image" accept="image/png, image/gif, image/jpeg" />
                                        <input type="submit" class="btn btn-success"  value="Upload image">
                                    </div>

                                </form>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            

    <div class="chat-box overflow-auto">

        
    <script>
        var nums=0;
    </script>


        <?php

        $msgs=get_messages();

        
        foreach ($msgs as $t => $message) {
            $username=$message['username'];

            if ($username==$_COOKIE["username"]){
        ?>

        <div class="my-message" id="<?php echo 'message-number'.$t ?>">
            
        <?php if (isset($proimgs[$_COOKIE["username"]])){?>
                            <div class="">
                                <img class="img-fluid imagee" src="<?php echo $proimgs[$_COOKIE["username"]] ?>" >
                            </div>
                <?php
                }
               else{?>

                            <div class="image">
                                <?php echo strtoupper($pronames[$_COOKIE["username"]][0]) ?>
                            </div>
                            
                <?php
                }
                
               if ($message["type"] == "image"){?>

                    <span class="my-chat-image">
                        <a href="<?php echo $message["message"] ?>" target="_blank" rel="noopener noreferrer"><img class="chat-image" src="<?php echo $message["message"] ?>" ></a>
                    </span>

                    <?php if(!in_array($_COOKIE["username"],$blockusers)){?>

                    <button class="btn delete" id="<?php echo 'delete-number'.$t ?>"><i class="bi bi-trash3"></i></button>

                    <?php }?>

                <?php
                }

                elseif ($message["type"] == "text"){
                ?>


            <span class="my-chat"><?php echo $message["message"] ?></span>

            <?php if(!in_array($_COOKIE["username"],$blockusers)){?>

            <button class="btn delete" id="<?php echo 'delete-number'.$t ?>"><i class="bi bi-trash3"></i></button>
            
            <button class="btn delete" id="<?php echo 'edit-number'.$t ?>"><i class="bi bi-pencil-square"></i></button>

            <?php
                }
                }
            ?>

            <script>
                nums+=1;
            </script>

        </div>

        <?php
            }
            else{
        ?> 
        
        <div class="other-message" id="<?php echo 'message-number'.$t ?>">


            <?php if (isset($proimgs[$username])){?>
                            <div class="">

                                <button class="btn p-0" id="<?php echo "profile".$t?>" name="<?php echo $username ?>">
                                    <img class="img-fluid imagee" src="<?php echo $proimgs[$username] ?>">
                                </button>

                            </div>
                            

                            <?php
                            }
                            else{?>


                            <button class="btn p-0" id="<?php echo "profile".$t?>" name="<?php echo $username ?>">

                                <div class="image "><?php echo strtoupper($pronames[$username][0]) ?></div>
                            
                            </button>

                            <?php
                            }
                            
                            if ($message['type'] == "image"){?>

                                <span class="other-chat-image">
                                    <a href="<?php echo $message['message'] ?>" target="_blank" rel="noopener noreferrer"><img class="chat-image" src="<?php echo $message['message'] ?>" ></a>
                                </span>
            
                            <?php
                                if ($_COOKIE["username"]=="admin"){?>

                                <button class="btn delete" id="<?php echo 'delete-number'.$t ?>"><i class="bi bi-trash3"></i></button>
            
                            <?php        
                                }
                            }
            
                            elseif($message['type'] == 'text'){
                            ?>


            <span class="other-chat"><?php echo $message['message'] ?></span>

            <?php
                                if ($_COOKIE["username"]=="admin"){?>

                                    <button class="btn delete" id="<?php echo 'delete-number'.$t ?>"><i class="bi bi-trash3"></i></button>
            
            <?php
                                }
        
        
                                }

            ?>

            <script>
                nums+=1;
            </script>

            
        </div>

        <?php
            }
            $t++;
        }
        ?>

        


    </div>


    <div class="send-box">

        <form action="" method="get" class="send-form">
        <?php if(in_array($_COOKIE["username"],$blockusers)){ ?>
            <input class="form-control send" type="text" name="msg" required  disabled value="You are block">      
            <?php
                }
                else{?>

            <input class="form-control send" type="text" name="msg" required pattern=".{0,100}">
            <button class="emoji btn btnn" type="button"><i class="bi bi-emoji-smile"></i></button>
            <script src="vanillaEmojiPicker.js"></script>
            
            <?php }?>    
            <button class="btn btnn" type="submit">
                <i class="bi bi-send-fill"></i>
            </button>
            
        </form>



    </div>


    <?php if(!in_array($_COOKIE["username"],$blockusers)){?>
    
    <button class="btn btnn position-absolute btn-image" type="button" data-bs-toggle="modal" data-bs-target="#selectimage">
                <i class="bi bi-image"></i>
            </button>
            <div class="modal fade" id="selectimage" tabindex="-1" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-2">

                            <label for="send-image" class="form-label">Choose a image</label>
                            <input class="form-control" name="send-image" type="file" id="send-image" accept="image/png, image/gif, image/jpeg" />
                            <input type="submit" class="btn btn-success"  value="Upload image">

                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        <?php }?>    



    <?php 
    if($_COOKIE["username"]=="admin"){?>

            <button class="btn btnn position-absolute btn-block" type="button" data-bs-toggle="modal" data-bs-target="#block-users">
                <i class="bi bi-dash-circle-fill"></i>
            </button>
            <div class="modal fade" id="block-users" tabindex="-1" >
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Send image</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" ></button>
                        </div>
                        <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-2">

                            <label for="block" class="form-label">Type a username to block:</label>
                            <input class="form-control" name="block" type="input" id="block"/>

                            <label for="unblock" class="form-label">Type a username to unblock:</label>
                            <input class="form-control" name="unblock" type="input" id="unblock"/>

                            <input type="submit" class="btn btn-success"  value="Submit">

                        </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


    <?php }?>
    

    <script>
        $(".my-chat").click(function(){
            $(".my-message").append('<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog">    <div class="modal-content">      <div class="modal-header">        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>      </div>      <div class="modal-body">        ...      </div>      <div class="modal-footer">        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>        <button type="button" class="btn btn-primary">Save changes</button>      </div>    </div>  </div></div>')
            $("#exampleModal").show()
        })


        new EmojiPicker({
            trigger: [
                {
                    selector: '.emoji',
                    insertInto: '.send'
                }
            ],
            closeButton: true,
            //specialButtons: green
        });


        for (let i = 1; i <= nums+1; i++) {




            $("#delete-number"+i).click(function(){
                var del=prompt("If you sure to delete this message, please type '+'");
                if (del=="+"){
                $("#message-number"+i).hide();

                document.cookie=`deleted_msg=${i}`; 

                window.location.reload();

                }
            })





            $("#edit-number"+i).click(function(){
                var edit=prompt("Type your message for edit");

                document.cookie=`edited_msg=`+edit;
                document.cookie=`num_msg=${i}`; 
                
                window.location.reload();
                
            })



            $("#profile"+i).click(function(){
                var username=$(`#profile${i}`).attr("name");
                console.log(username);

                document.cookie = `prouser=${username}`;

                window.location.reload();


            })
            
        }
    </script>


           
               
                       
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  </body>
</html>

