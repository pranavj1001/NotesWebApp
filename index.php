<?php

    session_start();
    $error = "";    

    if (array_key_exists("logout", $_GET)) { 
        unset($_SESSION);
        setcookie("id", "", time() - 60*60);
        $_COOKIE["id"] = "";      
    } else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {      
        header("Location: loggedinpage.php");       
    }


    if (array_key_exists("submit", $_POST)) {
        
        $link = mysqli_connect("localhost", "root", "", "spaceventure1");       
        if (mysqli_connect_error()) {      
            die ("Database Connection Error");         
        }
        
        
        if (!$_POST['email']) {       
            $error .= "An email address is required<br>";          
        }        
        if (!$_POST['password']) {        
            $error .= "A password is required<br>";          
        } 
        
        if ($error != "") {     
            $error = "<p>There were error(s) in your form:</p>".$error;
            
        } else {
            
            if ($_POST['signUp'] == '1') {
            
                $query = "SELECT id FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."' LIMIT 1";
                $result = mysqli_query($link, $query);

                if (mysqli_num_rows($result) > 0) {
                    $error = "That email address is taken.";
                } else {

                    $query = "INSERT INTO `users` (`email`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['email'])."', '".mysqli_real_escape_string($link, $_POST['password'])."')";

                    if (!mysqli_query($link, $query)) {
                        $error = "<p>Could not sign you up - please try again later.</p>";
                    } else {

                        $query = "UPDATE `users` SET password = '".md5(md5(mysqli_insert_id($link)).$_POST['password'])."' WHERE id = ".mysqli_insert_id($link)." LIMIT 1";
                        mysqli_query($link, $query);
                        $_SESSION['id'] = mysqli_insert_id($link);

                        if ($_POST['stayLoggedIn'] == '1') {
                            setcookie("id", mysqli_insert_id($link), time() + 60*60*24*365);
                        } 
                        header("Location: loggedinpage.php");
                    }

                } 
                
            } else {
                    
                    $query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST['email'])."'";
                    $result = mysqli_query($link, $query);           
                    $row = mysqli_fetch_array($result);
                
                    if (isset($row)) {
                        
                        $hashedPassword = md5(md5($row['id']).$_POST['password']);
                        
                        if ($hashedPassword == $row['password']) {
                            
                            $_SESSION['id'] = $row['id'];                          
                            if ($_POST['stayLoggedIn'] == '1') {
                                setcookie("id", $row['id'], time() + 60*60*24*365);
                            } 
                            header("Location: loggedinpage.php");                        
                        } else {                       
                            $error = "That email/password combination could not be found.";                
                        }                      
                    } else {                   
                        $error = "That email/password combination could not be found.";                      
                    }               
                }
            
        }       
        
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Notes Web App</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="NotesCss.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
      <a class="navbar-brand" href="#">Project name</a>
      <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </nav>

    <div class="container">

      <div class="starter-template">
          
        <h1>Notes</h1>
          
        <p class="lead">Use this document as a way to quickly start any new project.<br> All you get is this text and a mostly barebones HTML document.</p>
          
        <div id="error"><?php echo $error; ?></div>
          
        <form method="post">
            <input type="email" name="email" placeholder="Your Email">
            <input type="password" name="password" placeholder="Password">
            <input type="checkbox" name="stayLoggedIn" value=1>
            <input type="hidden" name="signUp" value="1">
            <input type="submit" name="submit" value="Sign Up!">
        </form>

        <form method="post">
            <input type="email" name="email" placeholder="Your Email">
            <input type="password" name="password" placeholder="Password">
            <input type="checkbox" name="stayLoggedIn" value=1>
            <input type="hidden" name="signUp" value="0">
            <input type="submit" name="submit" value="Log In!">
        </form>
          
      </div>
    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
