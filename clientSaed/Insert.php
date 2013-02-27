<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

//in base a quale tipo di server voglio inserire viene richiamata la funzione corrispondente
if(isset($_POST['insD'])) 
    $res = $functionSOAP->insertDS($_SESSION['utente'], $_SESSION['pwd'], $_POST['category'], $_POST['cpu'], $_POST['ram'], $_POST['HardDisk'], $_POST['price']);

if(isset($_POST['insM'])) 
    $res = $functionSOAP->insertM($_SESSION['utente'], $_SESSION['pwd'], $_POST['cpu'], $_POST['ram'], $_POST['HardDisk'], $_POST['slot']);

if(isset($_POST['insV'])) 
    $res = $functionSOAP->insertVS($_SESSION['utente'], $_SESSION['pwd'], $_POST['category'], $_POST['cpu'], $_POST['ram'], $_POST['HardDisk'], $_POST['price'], $_POST['machine']);
    

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            div {font-family:verdana; text-align: center}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            H4 {font-family:verdana; text-align: center; color: blue}
        </style>       
    </head>
    <body>
        <h3>Inserimento nuovi Server</h3><br>
        <div>
        <form method="post" action="AdminPage.php">
            <input type="submit" name="go_server" value="amministra server">
        </form>
        <br>
        <form method="post" action="Home.php">
            <input type="submit" name="go_home" value="torna alla home">
        </form>
        </div>
        <br>
        <!-- inserisco le caratteristiche del server-->
        <h4>Nuovo Server Dedicato</h4>
        <div>
        <form method="post">
            Categoria: <input type="text" name="category"><br>
            Cpu: <input type="text" name="cpu"><br>
            Ram: <input type="text" name="ram"><br>
            Hard Disk: <input type="text" name="HardDisk"><br>
            Prezzo: <input type="text" name="price"><br>
            <input type="submit" name="insD" value="inserisci">
        </form>  
        <?php //se l'inserimento non va a buon fine viene stampato un messaggio di errore
        if(isset($_POST['insD']) and ($res != 1)) echo "errore nell'inserimento del nuovo server"?>
        </div>
        <h4>Nuova Macchina</h4>
        <div>
        <form method="post">
            Cpu: <input type="text" name="cpu"><br>
            Ram: <input type="text" name="ram"><br>
            Hard Disk: <input type="text" name="HardDisk"><br>
            Slot Virtuali: <input type="text" name="slot"><br>
            <input type="submit" name="insM" value="inserisci">
        </form> 
        <?php if(isset($_POST['insM']) and ($res != 1)) echo "errore nell'inserimento della nuova macchina"?>
        </div>
        <h4>Nuovo Server Virtuale</h4>
        <div>
        <form method="post">
            Categoria: <input type="text" name="category"><br>
            Cpu: <input type="text" name="cpu"><br>
            Ram: <input type="text" name="ram"><br>
            Hard Disk: <input type="text" name="HardDisk"><br>
            ID Macchina:<input type="text" name="machine"><br>
            Prezzo: <input type="text" name="price"><br>
            <input type="submit" name="insV" value="inserisci">
        </form>  
        <?php if(isset($_POST['insV']) and ($res != 1)) echo "errore nell'inserimento del nuovo server"?>
        </div>
    </body>
</html>