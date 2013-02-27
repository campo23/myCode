<?php

include('functionSOAP.php');
$functionSOAP = new FunctionSOAP();

if(isset($_POST['contract']))
    $exCon = $functionSOAP->extendContract($_SESSION['utente'], $_SESSION['pwd'], $_POST['new_id'], $_POST['contract']);

if(isset($_POST['OS']))
    $chOS = $functionSOAP->changeOS($_SESSION['utente'], $_SESSION['pwd'], $_POST['new_id'], $_POST['OS']);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <style type="text/css">
            body {background-image: url(sfondo.jpg); background-attachment: fixed;}
            #tab {font-family:verdana; width:500px;margin:auto;border:1px solid black}
            H3 {font-family:verdana; text-align: center; color: darkblue}
            div {font-family:verdana; text-align: center}
            TD {text-align: center}
        </style>        
    </head>
    <body>
        <script type="text/javascript">
            function Edit(element) {
                /*questa funzione permette di dividere la stringa my_ID_prezzo in
                 *tre parti: my, ID e prezzo, in modo tale da poter inviare alla 
                 *pagina Edit.php l'ID e il prezzo del server selezionato nella 
                 *tabella attraverso il form "edit"*/
                idServer = element.getAttribute("id");
                arrayS = idServer.split("_");
                id_server = document.getElementById("h_id");
                id_server.value = arrayS[1];
                price_server = document.getElementById("h_price");
                price_server.value = arrayS[2];
                form = document.getElementById("edit");
                form.submit();
            }
        </script>
        <form method="post" id="edit" action="Edit.php">
            <input type="hidden" id="h_id" name="hidden_id_s">
            <input type="hidden" id="h_price" name="hidden_price">
        </form>
        <table>
        <tr>
            <h3>I Miei Server</h3>
                <table border="1" id="tab" cellpadding="5">    
                    <tr style="font-family:verdana; color:blue">
                    <td>Categoria</td>  
                    <td>Cpu</td>  
                    <td>Ram</td>
                    <td>HardDisk</td>
                    <td>Sistema Operativo</td>
                    <td>Tipo</td>
                    <td>Prezzo(€)</td> 
                    <td>Termine Contratto</td>
                    <td>Opzioni</td>
                    </tr>
                    <?php $functionSOAP->getMyServer($_SESSION['utente'], $_SESSION['pwd']);?> 
                </table>
        </tr>
        </table>
        <br>
        <div>
        <form method="post" action="Home.php">
            <input type="submit" value="torna alla home">
        </form>
        </div>
    </body>
</html>