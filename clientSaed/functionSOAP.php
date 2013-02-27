<?php

session_start();
require_once("nusoap.php");

class FunctionSOAP {
    
    var $client;

    public function __construct() {
        
        //creo il client nusoap
        $this->client = new nusoap_client('http://aclp2.no-ip.org:8080/axis2/services/Hosting?wsdl', true);

        $err = $this->client->getError();

        if ($err) 
            return 0;
    }
    //funzione login
    public function login($utente, $pass) {
        
        $param=array('args0'=>$utente, 'args1'=>$pass);
        
        //per chiamare le funzioni chiamata $client->call() che prende due parametri
        //il primo è il nome della funzione, il secondo è un array che può o essere vuoto (array())
        //oppure contenere i vari parametri richiesti dalla funzione (array('args0'=>param1, 'args1'=>param2 ecc..))
        $users = $this->client->call('login', $param);
        
        $users = $users['return'];
                
        if($users != 0) {
            
            //se il login è andato a buon fine, salvo dentro la sessione (grazie alla variabile $_SESSION
            //il nome utente, la password e il tipo di utente (utente o amministratore) 
            $_SESSION['utente'] = $utente;
            $_SESSION['pwd'] = $pass;
            $_SESSION['type'] = $users;
        
            return 1;
        }  
        
        return 0;
        
       
    }
    
    //funzione registrazione
    public function registration($utente, $pass, $email) {
        
        $param=array('args0'=>$utente, 'args1'=>$pass, 'args2'=>$email);
        
        $user = $this->client->call('registration', $param);
        
        $user = $user['return'];
        
        return $user;
    }

    //funzione che restituisce tutti i server dedicati liberi
    public function getFDS() {
        
        $freeServer = $this->client->call('getFreeDedicatedServers', array());
        
        $freeServer = $freeServer['return'];
        
        //dato che la funzione mi ritorna una stringa, uso json_decode per codificare la stringa in formato JSON
        $freeServer = json_decode($freeServer, true);
        
        //riempio la tabella con i valori contenuti nell'array $freeserver
        for($i=0; $i<count($freeServer); $i++) {
            echo"  
                <tr>    
                <td>".$freeServer[$i]['Category']."</td>  
                <td>".$freeServer[$i]['Cpu']."</td>  
                <td>".$freeServer[$i]['Ram']."</td>
                <td>".$freeServer[$i]['HardDisk']."</td>
                <td>".$freeServer[$i]['Price']."</td>";
                //se l'utente è connesso e non è un amministratore, creo un bottone che richiama la funzione javascript
                //Contract() e imposto come id la stringa buy_ID_prezzo 
                if(@$_SESSION['utente'] != "" and @$_SESSION['type'] == 1) {   
                    echo "<td><form method=\"post\"><input type=\"button\" id=\"buy_".$freeServer[$i]['ID']."_".$freeServer[$i]['Price']."\" value=\"affitta\" onclick=Contract(this)></input></form></td>";
                };
                echo "</tr>";
            
        }

    }
    
    //funzione che restituisce tutti i server virtuali liberi
    //(il funzionamento è analogo a quello di getFDS())
    public function getFVS() {
        
        $freeServer = $this->client->call('getFreeVirtualServers', array());
        
        $freeServer = $freeServer['return'];
        
        $freeServer = json_decode($freeServer, true);
  
        for($i=0; $i<count($freeServer); $i++) {
            echo"
                <td>".$freeServer[$i]['Category']."</td>  
                <td>".$freeServer[$i]['Cpu']."</td>  
                <td>".$freeServer[$i]['Ram']."</td>
                <td>".$freeServer[$i]['HardDisk']."</td> 
                <td>".$freeServer[$i]['Price']."</td>";               
                if(@$_SESSION['utente'] != "" and @$_SESSION['type'] == 1) {   
                    echo "<td><form method=\"post\"><input type=\"button\" id=\"buy_".$freeServer[$i]['ID']."_".$freeServer[$i]['Price']."\" value=\"affitta\" onclick=Contract(this)></input></form></td>";
                };
                echo "</tr>";
            
        }

    }
    
    //funzione che restituisce tutti i server affittati da un dato utente
    public function getMyServer($user, $pass) {
        
        $param = array('args0'=>$user, 'args1'=>$pass);       
        
        $myServer = $this->client->call('getUserServers', $param);
        
        $myServer = $myServer['return'];
        
        $myServer = json_decode($myServer, true);
  
        for($i=0; $i<count($myServer); $i++) {
            echo "
                <td>".$myServer[$i]['Category']."</td>  
                <td>".$myServer[$i]['Cpu']."</td>  
                <td>".$myServer[$i]['Ram']."</td>
                <td>".$myServer[$i]['HardDisk']."</td> 
                <td>".$myServer[$i]['OperatingSystem']."</td>
                <td>".$myServer[$i]['Type']."</td>     
                <td>".$myServer[$i]['Price']."</td>
                <td>".$myServer[$i]['ExpirationDate']."</td>
                <td><form method=\"post\"><input type=\"button\" id=\"my_".$myServer[$i]['ID']."_".$myServer[$i]['Price']."\" value=\"modifica\" onclick=Edit(this)></input></form></td>
                </tr>";
            
        }
    }
    
    //funzione che restituisce tutte le macchine
    public function getMachine($user, $pass) {
        
        $param = array('args0'=>$user, 'args1'=>$pass);
        
        $machine = $this->client->call('getMachines', $param);
        
        $machine = $machine['return'];
        
        $machine = json_decode($machine, true);
        
        for($i=0; $i<count($machine); $i++) {
            echo"
                <td>".$machine[$i]['Cpu']."</td>  
                <td>".$machine[$i]['Ram']."</td>
                <td>".$machine[$i]['HardDisk']."</td> 
                <td>".$machine[$i]['ID']."</td> 
                <td>".$machine[$i]['VirtualSlots']."</td>
                <td><form method=\"post\"><input type=\"button\" id=\"admM_".$machine[$i]['ID']."\" value=\"elimina\" onclick=delIdMachine(this)></input></form></td>
                </tr>";
            
        }
        
    }
    
    //funzione che elimina la macchina selezionata
    public function deleteM($user, $pass, $id) {
        
        $param = array('args0'=>$user, 'args1'=>$pass, 'args2'=>$id);
        
        $del = $this->client->call('deleteMachine', $param);
        
        $del = $del['return'];
       
        return $del;
    }
    
    //funzione che restituisce tutti i server
    public function getAS($user, $pass) {
        
        $param = array('args0'=>$user, 'args1'=>$pass);
        
        $allServer = $this->client->call('getAllServers', $param);
       
        $allServer = $allServer['return'];
        
        $allServer = json_decode($allServer, true);
  
        for($i=0; $i<count($allServer); $i++) {
            echo"
                <td>".$allServer[$i]['Category']."</td>  
                <td>".$allServer[$i]['Cpu']."</td>  
                <td>".$allServer[$i]['Ram']."</td>
                <td>".$allServer[$i]['HardDisk']."</td> 
                <td>".$allServer[$i]['ID']."</td> 
                <td>".$allServer[$i]['ID_User']."</td> 
                <td>".$allServer[$i]['Type']."</td>
                <td>".$allServer[$i]['Price']."</td>
                <td><form method=\"post\"><input type=\"button\" name=\"delete\" id=\"admS_".$allServer[$i]['ID']."\" value=\"elimina\" onclick=delIdServer(this)></input></form></td>    
                </tr>";
            
        }

    }
    
    //funzione che elimina il server selezionato
    public function deleteS($user, $pass, $id) {
        
        $param = array('args0'=>$user, 'args1'=>$pass, 'args2'=>$id);
        
        $del = $this->client->call('deleteServer', $param);
        
        $del = $del['return'];
       
        return $del;
        
    }
    
    //funzione che permette di affittare un server
    public function buyServer($user, $pass, $id, $os, $long) {
        
        $param = array('args0'=>$user, 'args1'=>$pass,'args2'=>$id, 'args3'=>$os, 'args4'=>$long);
        
        $res = $this->client->call('saveContract', $param);
        
        $res = $res['return'];
        
        return $res;
    }
    
    //funzione che permette di estendere il contratto
    public function extendContract($user, $pass, $id, $long) {
        
        $param = array('args0'=>$user, 'args1'=>$pass,'args2'=>$id, 'args3'=>$long);
        
        $res = $this->client->call('extendContract', $param);
        
        $res = $res['return'];
        
        return $res;
    }
    
    //funzione che permette di cambiare il sistema operativo
    public function changeOS($user, $pass, $id, $os) {
        
        $param = array('args0'=>$user, 'args1'=>$pass,'args2'=>$id, 'args3'=>$os);
        
        $res = $this->client->call('changeOperatingSystem', $param);
        
        $res = $res['return'];
        
        return $res;
    }
    
    //funzione per l'inserimento di un server dedicato
    public function insertDS($user, $pass, $category, $CPU, $ram, $HD, $price) {
        
        $param = array('args0'=>$user, 'args1'=>$pass, 'args2'=>$category, 'args3'=>$CPU, 'args4'=>$ram, 'args5'=>$HD, 'args6'=>$price);
        
        $res = $this->client->call('insertDedicatedServer', $param);
        
        $res = $res['return'];
        
        return $res;            
    }
    
    //funzione per l'inserimento di una macchina
    public function insertM($user, $pass, $CPU, $ram, $HD, $slot) {
        
        $param = array('args0'=>$user, 'args1'=>$pass, 'args2'=>$CPU, 'args3'=>$ram, 'args4'=>$HD, 'args5'=>$slot);
        
        $res = $this->client->call('insertMachine', $param);
        
        $res = $res['return'];
        
        return $res;            
    }
    
    //funzione per l'inserimento di un server virtuale
    public function insertVS($user, $pass, $category, $CPU, $ram, $HD, $price, $id_machine) {
        
        $param = array('args0'=>$user, 'args1'=>$pass, 'args2'=>$category, 'args3'=>$CPU, 'args4'=>$ram, 'args5'=>$HD, 'args6'=>$price, 'args7'=>$id_machine);
        
        $res = $this->client->call('insertVirtualServer', $param);
        
        $res = $res['return'];
     
        return $res;            
    }
}
?>