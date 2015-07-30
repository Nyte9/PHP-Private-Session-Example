<head>
    <title>Session ID Cookies</title>
<style type="text/css">

    body{
        line-height: 25px;
        font-family: Helvetica;
       
    }
    .container{
        position:absolute;
        width:40%;
        left:30%;
    }
</style>
</head>

<body><br>
<div class='container'>
<h1>Cookie SessionID Test</h1>
<div class='animated' id='animated'></div>

<?php

$csID; //current session ID
$signedIn = false;


//Check to see if user logs out
    if(isset($_GET["logout"])){
        unlink('names/' . $_GET["logout"] . '.txt');
        unset($_COOKIE['sID']);
        setcookie('sID', '', time() - 3600, '/'); //sets the cookie to a null value
        header('Location: https://test-ws-nyte9.c9.io/');
    }
//Checks to see if user wants to create a session
    if(isset($_GET['name'])){
        $name = $_GET['name'];
        echo '<br> Hello ' . $name . '<br>';
        $sID = generateRandomString();
     
        setcookie("sID", $sID);
        file_put_contents('names/' . $sID . '.txt', $name); //uses text files named after IDs to store names
        header('Location: https://test-ws-nyte9.c9.io/');
        
    }else{
//If not then it checks if the user has a session ID         
        if(isset($_COOKIE["sID"])){
            echo 'Hello ' . file_get_contents('names/' . $_COOKIE["sID"] . '.txt');
            echo '<br>your session ID is: ' . $_COOKIE["sID"];
            $signedIn = true;
            $csID = $_COOKIE["sID"];
        }else{
            //The user doesn't have an open session
            echo 'new user?';
        }
    }

    //Session IDs are a random 10 character long string
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
?>
    <br>
    Enter name to start a session<br>
    <form>
       <input style='width:200px;' type='text' placeholder='name' name='name'></input>
       
        <input type='submit'>
        <br>
        
    </form>
  <?php if($signedIn){ echo"<a style='position:absolute; right:50px;' href='?logout=" . $csID . "'>Sign out</a>"; }?>
    <!--Show logout button if logged in!-->
    <br>
    <small> This is a simple PHP script that can remember the name you have entered by storing a unique
    random ID on the client with cookies, this ID is also stored on the server and links to the name</small><br>
    <a style='position: absolute; right:10px' href='https://github.com/Nyte9/PHP-Private-Session-Example'>GitHub</a>
</div>
</body>
