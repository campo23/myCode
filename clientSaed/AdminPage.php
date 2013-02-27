<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

?>

<!DOCTYPE HTML>
<html>
    <head> 
        <meta charset="utf-8">
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            #tab {font-family:verdana; width:500px; margin:auto; border:1px solid black}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            H4 {font-family:verdana; text-align: center; color: blue}
            div {font-family:verdana; text-align: center}
            TD {text-align: center}
        </style>       
    </head>
    <body>
        <script type="text/javascript">
            function delIdServer(element) {
                //quando clicco sul pulsante elimina mi compare una finestra in cui viene chiesta la conferma
                //dell'eliminazione del server e in caso di risposta affermativa viene recuperato l'id del server
                //dalla string admS_id e viene passato alla funzione deleteS
                if(confirm('Vuoi davvero eliminare il server?')) {
                    idServer = element.getAttribute("id");
                    arrayS = idServer.split("_");
                    idH = document.getElementById("delHid");
                    idH.value=arrayS[1];
                    form = document.getElementById("delId");
                    form.submit();
                }
            }
        </script>
        <form method="post" id="delId" action="#">
            <input type="hidden" id="delHid" name="serverId">
        </form>
        <script type="text/javascript">
            function delIdMachine(element) {
                if(confirm('Vuoi davvero eliminare la macchina?')) {
                    idServer = element.getAttribute("id");
                    arrayS = idServer.split("_");
                    idH = document.getElementById("delMHid");
                    idH.value=arrayS[1];
                    form = document.getElementById("delMId");
                    form.submit();
                }
            }
        </script>
        <form method="post" id="delMId" action="#">
            <input type="hidden" id="delMHid" name="machineId">
        </form>
        <?php
            //elimino il server o la macchina in base a quale viene selezionato
            if (isset($_POST['serverId'])) {
                $delS = $functionSOAP->deleteS($_SESSION['utente'], $_SESSION['pwd'], $_POST['serverId']);
            }
            elseif (isset($_POST['machineId'])) {
                $delM = $functionSOAP->deleteM($_SESSION['utente'], $_SESSION['pwd'], $_POST['machineId']);
            }
        ?>
        <h3>Amministrazione Server</h3>
        <br>
        <div>
        <form method="post" action="Insert.php">
            <input type="submit" name="go_insert" value="Inserisci nuovo server">
        </form>
        <br>
        <form method="post" action="Home.php">
            <input type="submit" name="go_home" value="torna alla home">
        </form>
        </div>
        <br>
        <table>
        <tr>
            <h4>Macchine</h4>
                <table border="1" id="tab" cellpadding="5"> 
                    <tr  style="font-family:verdana; color:blue">
                    <td>Cpu</td>
                    <td>Ram</td>
                    <td>HardDisk</td>
                    <td>ID</td>
                    <td>Slot Virtuali</td>
                    <td>Opzioni</td>
                    </tr> 
                    <?php $functionSOAP->getMachine($_SESSION['utente'], $_SESSION['pwd'])?>
                </table>
        </tr>
        </table>
        <br>
        <table>
        <tr>
            <h4>Server</h4>
                <table border="1" id="tab" cellpadding="5">    
                    <tr style="font-family:verdana; color:blue">
                    <td>Categoria</td>  
                    <td>Cpu</td>  
                    <td>Ram</td>
                    <td>HardDisk</td>
                    <td>ID</td>
                    <td>ID Utente</td>
                    <td>Tipo</td>
                    <td>Prezzo(€)</td>
                    <td>Opzioni</td>
                    </tr>
                    <?php $functionSOAP->getAS($_SESSION['utente'], $_SESSION['pwd'])?> 
                </table>
        </tr>
        </table>  
        <br>
        <div>
        <?php
            //se le funzioni deleteS e deleteM retituiscono 0 non è stato possibile elimiare il server/macchina
            //e viene stampato un messaggio di errore
            //con il comando unset viene eliminata la variabile $_POST
            if(isset($_POST['serverId'])) {
                if($delS == 0) echo 'impossibile eliminare server';
                elseif($delS == 1) echo 'server eliminato';  
                unset($_POST['serverId']);
            }
            elseif (isset($_POST['machineId'])) {
                if($delM == 0) echo 'impossibile eliminare macchina';
                elseif($delM == 1) echo 'macchina eliminata';  
                unset($_POST['machineId']);
            }
        ?>
        </div>
    </body>
</html>