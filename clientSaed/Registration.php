<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

//quando clicco sul pulsante registrati viene richiamata la funzione registration 
if(isset($_POST)) 
    $reg = $functionSOAP->registration($_POST['utente'], $_POST['pwd'], $_POST['email']);

?>

<!DOCTYPE HTML>
<html>
    <head>
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            div {font-family:verdana; text-align: center}
        </style>
    </head>
    <body>
        <h3>Registrazione Nuovo Utente</h3>
        <div>
        <form method="post" action="#">
            Utente: <input type="text" name="utente"> <br>
            Password: <input type="password" name="pwd"> <br>
            Email: <input type="text" name="email"> <br>
            <input type="submit" name="registration" value="registrati">
        </form>
        </div>    
        <!-- se la chiamata di funzione è andata a buon fine la registrazione ha avuto successo,
        altrimenti viene stampato un messaggio di errore-->
        <p><?php if(isset($_POST['registration'])) {
            if($reg == 0) 
                echo "dati errati";
            else
                echo "registrazione riuscita! <br><br>";
        }
           ?></p>
        <div>
        <form method="post" action="Home.php">
            <input type="submit" name="go_on" value="torna alla home">
        </form>
        </div>
    </body>
</html>