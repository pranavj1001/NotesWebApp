<?php

    session_start();

    if (array_key_exists("id", $_COOKIE)) {        
        $_SESSION['id'] = $_COOKIE['id'];       
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
    <link href="loggedinpagecss.css" rel="stylesheet">
      
    <!-- Delius Unicase Font -->
    <link href="https://fonts.googleapis.com/css?family=Delius+Unicase" rel="stylesheet">
      
    <!-- PT Sans Font -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-fixed-top navbar-dark bg-inverse">
      <a class="navbar-brand" href="#">Notes</a>
      <ul class="nav navbar-nav">
        <!--<li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>-->
        <li id="logout" class="nav-item">
          <?php
                if (array_key_exists("id", $_SESSION)) {       
                    echo "<a class='nav-link' href='index.php?logout=1'>Log out</a>";       
                } else {       
                    header("Location: index.php");      
                }
            ?>
        </li>
      </ul>
    </nav>
      
    <div class="container notesArea">
          <textarea id="notes" class="form-control"></textarea>
    </div>
      
    <footer>
        <p>&copy;Pranav Jain 9th November,2016</p>
    </footer>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js" integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
      
    <script type="text/javascript">
      
        $('#notes').bind('input propertychange', function() {
            $.ajax({
              method: "POST",
              url: "updateDB.php",
              data: { content: $("#notes").val()}
            })
              .done(function( msg ) {
                alert( "Data Saved: " + msg );
            });
        });
      
    </script>
      
  </body>
</html>