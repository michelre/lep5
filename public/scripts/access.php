     <?php
     $name = 'zarco';   
     $pass = password_hash("filature",PASSWORD_DEFAULT);   
     $db = new PDO('mysql:host=localhost;dbname=projet5', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
     $req=  $db->prepare('INSERT INTO user( name, pass) VALUES( :name, :pass)');    
     $req->execute([':name'=>$name, ':pass'=>$pass]);
     
      ?>   
      