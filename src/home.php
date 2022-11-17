<?php
if(@$_GET['delete']){
    include('mess-db.php');
    $check = messModel::delete($_GET['delete']);
    if(!$check){
        print '<script>alert("Try again!");</script>';
    }
}
if (@$_SERVER['REQUEST_METHOD'] == 'POST') {
    include('mess-db.php');
    $message = $_POST['message'];
    $receiver = $_POST['userid'];
    $title = $_POST['title'];
    $sender = $_SESSION['user'];
    $check = messModel::save($message, $sender,$receiver,$title);
    if(!$check){
        print '<script>alert("Try again!");</script>';
    }
    else{
        print '<script>alert("Message sent");</script>';
    }
    print '<script>window.location.assign("/?page=home");</script>';
}
?>
<!-- ************** HTML CODE BOUNDARY ************** -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Challenge CTF </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <div class="pos-f-t">
        <nav class="navbar navbar-dark bg-dark">
            <div class="d-flex">
                <div class="p-2">
                </div>
                <?php
                if (!@$_SESSION['user']) {
                    echo "

                    <div class='p-2'>
                    <button type='button' class='btn btn-outline-danger' onclick='signup()' style='width: 90px'> <strong>Sign Up</strong></button>
                    </div>
                    
                    <div class='ml-auto p-2'>
                    <button type='button' class='btn btn-outline-warning' onclick='login()' style='width: 90px'><strong>Log In</strong></button>
                    </div>
                    ";
                } else {
                    echo "
                    <div class='p-2'><button type='button' class='btn btn-light' onclick='logout()' style='width:100px'>Logout</button></div>
                    ";
                }
                ?>
            </div>
            <div style="margin-left: 10%">
                <h1 style="color:white; "><a href="/?page=home" style="color:white;text-decoration:none">CTF103</a>&nbsp;&nbsp;&nbsp;&nbsp;</h1>
            </div>
        </nav>
        <div class="d-flex justify-content-center"></div>
    </div>
</head>
<!-- ************** HTML CODE BOUNDARY ************** -->

<body style="background-color:#967c56">
    <?php
    include('mess-db.php');
    $isadmin = false;
    if($_SESSION['user']!=='admin'){
        $message = messModel::get($_SESSION['user']);
    }
    else{
        $message = messModel::admin_get();
        $isadmin=true;
    }
    if (@$_SESSION['user']) {
        echo "
        <div class='d-flex mb-3'>
        <div class='p-2 flex-fill' style='width:23%;margin-top:48px'>";
        if(@$message){
            $html='';
            foreach($message as $m){
                $html.="<div class='alert alert-success' style='word-wrap: break-word; width:fit-content;'>
                <strong>".$m[1].": </strong>"."[".$m[3]."] - ".$m[4]."<span class='isadmin' id='".$m[0]."'></span></div> ";
            }
            echo $html;
        }
        else{
            echo "            
            <div class='alert alert-danger' style='width:fit-content; word-wrap: break-word;'>
            <strong>System:</strong> No message in your inbox!
            </div>";
        }
        echo "
        </div>
        <div class='p-2 flex-fill ' style='width:10%'>
            <div class='container py-5'>
                <div class='row d-flex justify-content-center'>
                    <div class='col-md-8 col-lg-6 col-xl-4'>
                        <div class='card' id='chat1' style='border-radius: 15px; width:200%;'>
                            <div class='card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0'
                                style='border-top-left-radius: 15px; border-top-right-radius: 15px;'>
                                <i class='fas fa-angle-left'></i>
                                <p class='mb-0 fw-bold' style='color:black'>[Chat Chit]</p>
                                <i class='fas fa-times'></i>
                            </div>
                            <div class='card-body'>
                                <div class='form-outline'>
                                    <form action='/?page=home' method='post'>
                                        <textarea class='form-control' id='textAreaExample'
                                            placeholder='You want to send this message to whom?' rows='1'
                                            name='userid'></textarea>
                                        <label class='form-label' for='textAreaExample' style='color:red'><b>Send to
                                                ?</b></label>
                                        <textarea class='form-control' id='textAreaExample'
                                            placeholder='Type in message title' rows='1' name='title'></textarea>
                                        <label class='form-label' for='textAreaExample'
                                            style='color:green'><b>Title</b></label>
                                        <textarea class='form-control' id='textAreaExample' rows='10'
                                            name='message'></textarea>
                                        <label class='form-label' for='textAreaExample' style='color:blue'><b>Type your
                                                message</b></label>
                                        <hr>
                                        <button type='submit' style='margin-left:77%;border-radius:1.3em;width:90px'>Send
                                            ❤</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div />
        </div>
        ";
    } else {
        echo "
        <div class='alert alert-success' role='alert' id='alert' style='width:550px; margin-left:32%; margin-top:35px'>
        <button onclick='hideit()' style='background-color:#f50707; border-radius:40%; font-size:15px; margin-left:95%'>
            <strong>x</strong>
        </button>
        <h4 class='alert-heading'>Hello Heck3r!</h4>
        <p>It's too funny to chat with someone, isn't it?</p>
        <hr>
        <p class='mb-0'>But you have to login first!!!</p>
    </div>
          ";
    }
    if(@$isadmin){
        print "<script>
        arr = document.getElementsByClassName('isadmin');
        for(var i = 0 ;i < arr.length;i++){
            idd=arr[i].id;
            arr[i].innerHTML='&nbsp;&nbsp;<button style=\"background-color:#b50f04; border-radius:25%\" onclick=\"del(idd)\">x</button>';}
        function del(data){
            const req = new XMLHttpRequest();
            req.open(\"GET\", \"/?page=home&delete=\"+data);
            req.send();
            document.location='/?page=home'
        }
        </script>";
    }
    ?>
</body>
<!-- ************** HTML CODE BOUNDARY ************** -->
<script>
    function login() {
        document.location = "/?page=login"
    }

    function logout() {
        document.location = "/?page=logout"
    }

    function signup() {
        document.location = "/?page=signup"
    }

    function hideit() {
        document.getElementById('alert').style.display = 'none'
    }
</script>