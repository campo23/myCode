<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

if(isset($_POST) && $_SESSION['utente'] == "")
{
    $log = $functionSOAP->login($_POST['utente'], $_POST['pwd']);
}
?>

<!DOCTYPE HTML>
<html>  
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            .tab {font-family:verdana; width:500px;margin:auto;border:1px solid black}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            H4 {font-family:verdana; text-align: center; color: blue}
            div {font-family:verdana; text-align: center}
            TD {text-align: center}
        </style>       
    </head>
    
    <body>
        <script type="text/javascript">
            function Contract(element) {
                /*questa funzione permette di dividere la stringa buy_ID_prezzo in
                 *tre parti: buy, ID e prezzo, in modo tale da poter inviare alla 
                 *pagina Contract.php l'ID e il prezzo del server selezionato nella 
                 *tabella attraverso il form "buy_contract"*/
                idServer = element.getAttribute("id");
                arrayS = idServer.split("_");
                id_server = document.getElementById("h_id");
                id_server.value = arrayS[1];
                price_server = document.getElementById("h_price");
                price_server.value = arrayS[2];
                form = document.getElementById("buy_contract");
                form.submit();
            }
        </script>
        <div>
            <h3>Home</h3>
        </div>
        <?php
        if($_SESSION['utente'] == "") { 
        ?>
        <!-- se l'utente non è connesso creo i campi Utente e Password e i due bottoni login e registrati-->
        <div>           
            <form method="post">            
                Utente: <input type="text" name="utente"> <br>
                Password: <input type="password" name="pwd"> <br>
                <input type="submit" name="login" value="login"> <br> 
                <input type="button" id="reg" value="registrati"  onclick="location.href='Registration.php'">
            </form>
        </div>
        <?php
        }        
        else {
            if($_SESSION['type'] == 1) {
        ?>
        <!-- se l'utente è di tipo 1 allora è un utente normale, quindi creo il pulsante che porta alla User Page-->
        <div>
        <form method="post" action="UserPage.php">
            <input type="submit" name="serverPage" value="vai ai server">
        </form>
        <br>
        </div>
        <?php }
            else if($_SESSION['type'] == 2) {
        ?>
        <!-- se l'utente è di tipo 2 allora è un amministratore, quindi creo il pulsante che porta alla Admin Page-->
        <div>
        <form method="post" action="AdminPage.php">
            <input type="submit" name="admS" value="amministra server">
        </form>
        </div>
        <br>
        <?php } ?>
        <div>
        <form method="post" action="#">
            <input type="submit" name="logout" value="logout">
        </form>
        </div>
        <?php
        /*funzione di logout*/
            if(isset($_POST['logout'])) {
                session_destroy();
                header('location: Home.php');
                exit();
            }
        ?>
        <?php
        }
        ?>
        <form method="post" id="buy_contract" action="Contract.php">
            <input type="hidden" id="h_id" name="hidden_id_s">
            <input type="hidden" id="h_price" name="hidden_price">
        </form>
        <a><?php
            if(isset($_POST['login']))
                if(@$_SESSION['utente'] == "") echo "login errato"; ?></a>
        <br>
        <table>
        <tr>
            <h4>Server Dedicati Liberi</h4>
                <table border="1" class="tab" cellpadding="5">    
                    <tr style="font-family:verdana; color:blue">
                    <td>Categoria</td>  
                    <td>Cpu</td>  
                    <td>Ram</td>
                    <td>HardDisk</td>
                    <td>Prezzo(€)</td>                    
                    </tr>
                    <!-- creo la prima riga contenente i titoli delle varie colonne
                    e poi richiamo la funzione che mi finisce di creare la tabella-->
                    <?php $functionSOAP->getFDS()?> 
                </table>
        </tr>
        <br>
        <tr>
            <h4>Server Virtuali Liberi</h4>
                <table border="1" class="tab" cellpadding="5">    
                    <tr  style="font-family:verdana; color:blue">
                    <td>Categoria</td>  
                    <td>Cpu</td>  
                    <td>Ram</td>
                    <td>HardDisk</td>
                    <td>Prezzo(€)</td>                    
                    </tr>
                    <?php $functionSOAP->getFVS()?>   
                </table>
        </tr>
        </table>
        <br>
    </body>
</html>
