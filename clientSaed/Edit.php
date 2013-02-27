<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

//quando viene cliccato il pulsante modifica viene chiamata la funzione extendContract e come parametri vengono
//passati nome utente, password, id del server, sistema operativo e la durata, se uno degli ultimi due campi non viene 
//selezionato non viene modificato
if(isset($_POST['modifica']))
    $ctr = $functionSOAP->extendContract($_SESSION['utente'], $_SESSION['pwd'], $_POST['idS'], $_POST['OS'], $_POST['contract']);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            .tab {font-family:verdana; width:500px; margin:auto}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            H4 {font-family:verdana; text-align: center}
            div {font-family:verdana; text-align: center}
            TD {text-align: center}
        </style>
    </head>
    <body>
        <div>
        <h3>Modifica Contratto</h3>
        <form method="post" action="UserPage.php">
            <h4>Cambia Sistema Operativo:</h4> 
            <!-- seleziono il nuovo sistema operativo-->
                                <table class="tab">
                                <tr><td><input type="radio" name="OS" value="Windows Server 2003">Windows Server 2003</td></tr>
                                <tr><td><input type="radio" name="OS" value="Windows Server 2008">Windows Server 2008</td></tr>
                                <tr><td><input type="radio" name="OS" value="Windows Server 2012">Windows Server 2012</td></tr>
                                <tr><td><input type="radio" name="OS" value="Debian">Debian</td></tr>
                                <tr><td><input type="radio" name="OS" value="Red Hat">Red Hat</td></tr>
                                <tr><td><input type="radio" name="OS" value="Ubuntu Server">Ubuntu Server</td></tr>
                                <tr><td><input type="radio" name="OS" value="Fedora Server">Fedora Server</td></tr>
                                
                                </table>
            <h4>Prolunga Contratto:</h4>
            <!-- seleziono di quanto voglio prolungare il contratto-->
                                <table class="tab" cellpadding="5">
                                <tr><td><table border="1">
                                            <tr><td>Durata: 1 Mese<br>
                                            Sconto: 0%<br>
                                            <!-- stampo il prezzo totale in base al prezzo del server moltiplicato
                                            per il numero di mesi e applicando, se presente, lo sconto-->
                                            Prezzo: <?php echo $_POST['hidden_price']?>€<br>
                                            <input type="radio" name="contract" value="1">seleziona</td></tr>
                                        </table>
                                    </td>
                                    <td><table border="1">
                                            <tr><td>Durata: 2 Mesi<br>
                                            Sconto: 0%<br>
                                            Prezzo: <?php echo $_POST['hidden_price']*2;?>€<br>
                                            <input type="radio" name="contract" value="2">seleziona</td></tr>
                                        </table>
                                    </td>
                                    <td><table border="1">
                                            <tr><td>Durata: 6 Mesi<br>
                                            Sconto: 10%<br>
                                            Prezzo: <?php echo 6*$_POST['hidden_price']*90/100;?>€<br>
                                            <input type="radio" name="contract" value="6">seleziona</td></tr>
                                        </table>
                                    </td>
                                    <td><table border="1">
                                            <tr><td>Durata: 1 Anno<br>
                                            Sconto: 20%<br>
                                            Prezzo: <?php echo 12*$_POST['hidden_price']*80/100;?>€<br>
                                            <input type="radio" name="contract" value="12">seleziona</td></tr>
                                        </table>
                                    </td>
                                </table>
            <input type="submit" name="modifica" value="modifica">
        </form>  
        <a><?php if(isset($_POST['contract'])) {
                //se la funzione extendContract mi ritorna 0 significa che non è andata
                    //a buon fine e quindi stampo un messaggio di errore
                    if($ctr == 0) 
                        echo "errore";
                } ?></a>
        <br>
        <form method="post" action="UserPage.php">
            <input type="submit" value="vai ai server">
        </form>
        <br>
        <form method="post" action="Home.php">
            <input type="submit" value="torna alla home">
        </form>
        </div>
    </body>
</html>