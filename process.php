<?php

//seb@optim.care

session_start();

$mysqli = new mysqli('localhost','root','','test');
mysqli_options($mysqli, MYSQLI_OPT_LOCAL_INFILE, true);

$update = false;
$id = 0;
$type = "";
$adresse = "";
$name = "";
$email = "";

//$adresse = ['',];

function randomName() {
    $names = array(
        'Juan','Luis','Pedro','Julian','Paul','Jean','Pierre','Arnaud','Henry','Ricardo','Patrick','Antoine','Camille','Laura','Julien','Guillaume','Sabine','Alain'
    );
    return $names[rand ( 0 , count($names) -1)];
}

function randomAdresse() {
    $adresses = array(
        '3, rue des Lacs 95220 HERBLAY','65, rue Gouin de Beauchesne 93400 SAINT-OUEN','77, rue Victor Hugo 60200 COMPIÈGNE', '90, rue Gouin de Beauchesne 91240 SAINT-MICHEL-SUR-ORGE',
        '24, rue des Coudriers 31600 MURET','45, Rue Roussy 93130 NOISY-LE-SEC', '84, Square de la Couronne 93500 PANTIN', '16, Place du Jeu de Paume 18100 VIERZON'
    );
    return $adresses[rand ( 0 , count($adresses) -1)];
}

function randomType() {
    $types = array(
        //'Serveur','Bucheron','Admin','Developpeur','Caissier','Professeur','Charpantier','Docteur','Client','Carossier','Peintre','Ouvrier'
        '1','2','3','4','5'
    );
    return $types[rand ( 0 , count($types) -1)];
}

function randomMail() {
    $mails = array(
        'Juan@gmail.com','Luis@gmail.com','Pedro@gmail.com','Julian@gmail.com','Paul@gmail.com','Jean@gmail.com','Pierre@gmail.com',
        'Arnaud@gmail.com','Henry@gmail.com','Ricardo@gmail.com','Patrick@gmail.com','Antoine@gmail.com','Camille@gmail.com',
        'Laura@gmail.com','Julien@gmail.com','Guillaume@gmail.com','Sabine@gmail.com','Alain@gmail.com',
        'Juan@yahoo.com','Luis@yahoo.com','Pedro@yahoo.com','Julian@yahoo.com','Paul@yahoo.com','Jean@yahoo.com','Pierre@yahoo.com',
        'Arnaud@yahoo.com','Henry@orange.com','Ricardo@orange.com','Patrick@jupimail.com','Antoine@jupimail.com','Camille@etu.unilim.fr',
        'Laura@etu.unilim.fr','Julien@hotmail.com','Guillaume@hotmail.com','Sabine@wanadoo.com','Alain@wanadoo.com',
        'Arnaud@laposte.com','Henry@laposte.com','Ricardo@laposte.com','Patrick@laposte.com','Antoine@laposte.com','Camille@laposte.fr',
        'Laura@sfr.fr','Julien@sfr.com','Guillaume@sfr.com','Sabine@sfr.com','Alain@sfr.com'
    );
    return $mails[rand ( 0 , count($mails) -1)];
}

function randomMailv2(){

    $randomString = '';
    $alphabetic     = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    for ($i = 0; $i < 12; $i++) {
        $randomString .= $alphabetic[rand(0, strlen($alphabetic) - 1)];
    }

    $gmail = $randomString.'@gmail.com';
    $yahoo = $randomString.'@yahoo.fr';
    $orange = $randomString.'@orange.fr';
    $jupimail = $randomString.'@jupimail.com';
    $hotmail = $randomString.'@hotmail.com';
    $etu = $randomString.'@etu.unilim.fr';
    $wanadoo = $randomString.'@wanadoo.com';
    $poste = $randomString.'@laposte.com';
    $sfr = $randomString.'@sfr.fr';

    $mails = array(
        $gmail,$yahoo,$orange,$jupimail,$jupimail,$hotmail,$etu,$wanadoo,$poste,$sfr
    );

    return $mails[rand ( 0 , count($mails) -1)];
}

function queryTime($sql)
{
    $mysqli = new mysqli('localhost','root','','test');

    $t0 = time();
    $mysqli->query($sql) or die($mysqli->error());
    $t1 = time();

    $time = $t1 - $t0;
    return $time;
}
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}


if (isset($_POST['save'])){
    $type = $_POST['type'];
    $adresse = $_POST['adresse'];
    $name = $_POST['nom'];
    $email = $_POST['email'];
    $mysqli->query("INSERT INTO users(type,adresse,nom,supprime,email) VALUES ('$type','$adresse','$name','0','$email')");

    $_SESSION['message'] = "Nouvelle utilisateur enregistré !";
    header ("Refresh: 1;URL=index.php");
}

if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $mysqli->query("UPDATE users SET supprime ='1' WHERE id_users='$id'");

    $_SESSION['message'] = "Utilisateur supprimé !";
    header ("Refresh: 1;URL=index.php");
}

if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM users WHERE id_users='$id'");

    $row = $result->fetch_array();
    $type = $row['type'];
    $adresse = $row['adresse'];
    $name = $row['nom'];
    $email = $row['email'];
}

if (isset($_POST['update'])){
    $id = $_POST['id'];

    $type = $_POST['type'];
    $adresse = $_POST['adresse'];
    $name = $_POST['nom'];
    $email = $_POST['email'];

    $mysqli->query("UPDATE users SET type='$type', adresse='$adresse', nom='$name', email='$email' WHERE id_users='$id'");

    $_SESSION['message'] = "Utilisateur modifié !";
    header ("Refresh: 1;URL=index.php");
}

/*
function arrayToCSV($inputArray)
{
    $csvFieldRow = array();
    foreach ($inputArray as $CSBRow) {
        $csvFieldRow[] = str_putcsv($CSBRow);
    }
    $csvData = implode("\n", $csvFieldRow);
    return $csvData;
}

function str_putcsv($input, $delimiter = ',', $enclosure = '"')
{
    $fp = fopen('file.csv', 'r+');
    fputcsv($fp, $input, $delimiter, $enclosure);
    rewind($fp);
    $data = fread($fp, 1048576);
    fclose($fp);
    return rtrim($data, "\n");
}*/

/*
if(isset($_POST['add5mV1'])){
    $mysqli->query("TRUNCATE Table users");

    $i = 0;*/
    /* /////////////////////////////////////////////////////////////////////////////////////////
     * V1 (Allowed memory size error)
     *
    $sql="INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ";
    for($i; $i < 5000000; $i++){
        if($i%10 == 0){
            $sql.="('staff','0$i Rue des palmiers','Louis$i', '0' ,'louis$i@gmail.com'),";
        }else{
            $sql.="('client','0$i église neuve de vergt','Henry$i', '0' ,'henry$i@gmail.com'),";
        }

    }
    $sql=rtrim($sql, ",");

    $t0 = microtime_float();
    $mysqli->query($sql) or die($mysqli->error());
    $t1 = microtime_float();
    */

    /* /////////////////////////////////////////////////////////////////////////////////////////
     * V2.1 (Allowed memory size error) avec While
     *
    $sqlTab = array();
    $i = 1;
    while ($i <= 5000000)
    {
        $sqlTab[$i] = "INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ('staff','0$i Rue des palmiers','Louis$i', '0' ,'louis$i@gmail.com')";
        $i++;
    }
    $i = 1;

    $t0 = microtime_float();
    while($i <= 5000000){
        $mysqli->query($sqlTab[$i]) or die($mysqli->error());
        $i++;
    }
    $t1 = microtime_float();
    $i--;
    */

    /* /////////////////////////////////////////////////////////////////////////////////////////
     * V2.2 (Maximum execution time exceeded in error) avec Foreach
     *
    $sqlTab = array();
    $i = 1;
    while ($i <= 100000)
    {
        $sqlTab[$i] = "INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ('staff','0$i Rue des palmiers','Louis$i', '0' ,'louis$i@gmail.com')";
        $i++;
    }

    $t0 = microtime_float();
    foreach($sqlTab as &$value){
        $mysqli->query($value) or die($mysqli->error());
    }
    $t1 = microtime_float();
    $i--;

    */

    /* /////////////////////////////////////////////////////////////////////////////////////////
     * V3 avec fichier csv
     *
    $sqlTab = array();
    $i = 1;
    $delimiter = ',';
    $enclosure = '"';

    while ($i <= 100)
    {
        $sqlTab = array("'staff','0$i Rue des palmiers','Louis$i', '0' ,'louis$i@gmail.com')");
        $i++;
    }
    $csvFieldRow = array();
    foreach ($sqlTab as $CSBRow) {
        $fp = fopen('php://temp', 'r+');
        fputcsv($fp, $CSBRow, $delimiter, $enclosure);
        rewind($fp);
        $data = fread($fp, 1048576);
        fclose($fp);
        $result = rtrim($data, "\n");

        $csvFieldRow[] = $result;
    }
    $csvData = implode("\n", $csvFieldRow);
    print "<PRE>";
    print $csvData;*/
    /*
    $sqlTab = array();
    $i = 1;

    while ($i <= 100)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMail();
        //$sqlTab[$i] = array($type,$adresse,$name, "0" ,$mail);
        array_push($sqlTab, array($type,$adresse,$name, "0" ,$mail));
        $i++;
    }
    print "<PRE>";
    print $CSVData = arrayToCSV($sqlTab);

    $t0 = microtime_float();
    $t1 = microtime_float();

    $time = $t1 - $t0;
    $i--;
    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    //$_SESSION['message'] = "$sql";
    header ("Refresh: 1;URL=index.php");
}
*/
/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['add5mV2'])){
    $mysqli->query("TRUNCATE Table users");

    $i = 0;

    $sqlTab = array();
    $i = 1;
    while ($i <= 100)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMail();
        $sqlTab[$i] = "INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ('$type','$adresse','$name', '0' ,'$mail')";
        $i++;
    }

    $t0 = microtime_float();
    foreach($sqlTab as &$value){
        $mysqli->query($value) or die($mysqli->error());
    }
    $t1 = microtime_float();
    $i--;

    $time = $t1 - $t0;

    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['add5mV3'])){
    $mysqli->query("TRUNCATE Table users");
    $requete = array();
    for($nbrRequest = 0; $nbrRequest < 500; $nbrRequest++){

        $sql="INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ";
        for($i = 0; $i < 10000; $i++){
            $type = randomType();
            $adresse = randomAdresse();
            $name = randomName();
            $mail = randomMail();
            $sql.="('$type','$adresse','$name', '0' ,'$mail'),";
        }
        $sql=rtrim($sql, ",");
        $requete[$nbrRequest] = $sql;
    }

    $t0 = microtime_float();
    for($x = 0; $x < $nbrRequest; $x++){
        $mysqli->query($requete[$x]) or die($mysqli->error());
    }
    $t1 = microtime_float();
    $time = $t1 - $t0;

    $i = $i * $nbrRequest;
    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
/*
if(isset($_POST['add5mV4'])){
    $mysqli->query("TRUNCATE Table users");

    $sqlTab = array();
    $i = 0;
    while ($i < 10000)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMail();
        array_push($sqlTab, array($type,$adresse,$name, "0" ,$mail));
        $i++;
    }

    $fp = fopen('file.csv', 'w');
    foreach ($sqlTab as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);

    $row = 1;

    $t0 = microtime_float();
    if (($handle = fopen("file.csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $type = $data[0];
            $adresse = $data[1];
            $name = $data[2];
            $mail = $data[4];
            $sql = "INSERT INTO users(type,adresse,nom,supprime,email)  VALUES ('$type','$adresse','$name', '0' ,'$mail')";
            $mysqli->query($sql) or die($mysqli->error());
        }
        fclose($handle);
    }
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////

if(isset($_POST['add5mV5'])){
    $mysqli->query("TRUNCATE Table users");

    $sqlTab = array();
    $i = 0;
    while ($i < 10000)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMail();
        array_push($sqlTab, array($type,$adresse,$name, "0" ,$mail));
        $i++;
    }

    $fp = fopen('file.csv', 'w');
    foreach ($sqlTab as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);


    $t0 = microtime_float();

        $fileName = "file.csv";

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {

                $type = "";
                if (isset($column[0])) {
                    $type = mysqli_real_escape_string($mysqli, $column[0]);
                }
                $adresse = "";
                if (isset($column[1])) {
                    $adresse = mysqli_real_escape_string($mysqli, $column[1]);
                }
                $nom = "";
                if (isset($column[2])) {
                    $nom = mysqli_real_escape_string($mysqli, $column[2]);
                }
                $supprime = "";
                if (isset($column[3])) {
                    $supprime = mysqli_real_escape_string($mysqli, $column[3]);
                }
                $email = "";
                if (isset($column[4])) {
                    $email = mysqli_real_escape_string($mysqli, $column[4]);
                }

                $sqlInsert = "INSERT into users (type,adresse,nom,supprime,email) values ('$type','$adresse','$nom','$supprime','$email')";
                $mysqli->query($sqlInsert);
            }
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}
*/
/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['add5mV6'])){
    $mysqli->query("TRUNCATE Table users");

    $sqlTab = array();
    array_push($sqlTab, array("id_users","type","adresse","nom", "supprime" ,"email"));
    $i = 0;
    while ($i < 2500000)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMailv2();
        array_push($sqlTab, array($i,$type,$adresse,$name, "0" ,$mail));
        $i++;
    }

    $fp = fopen('file1.csv', 'w');
    foreach ($sqlTab as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);

    $sqlTab2 = array();
    array_push($sqlTab2, array("id_users","type","adresse","nom", "supprime" ,"email"));

    while ($i <= 5000000)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMailv2();
        array_push($sqlTab2, array($i,$type,$adresse,$name, "0" ,$mail));
        $i++;
    }

    $fp2 = fopen('file2.csv', 'w');
    foreach ($sqlTab2 as $fields) {
        fputcsv($fp2, $fields);
    }
    fclose($fp2);


    $path = "file1.csv";
    $path2 = "file2.csv";

    $option = "OPTIONALLY ENCLOSED BY '\"' ";

    $sql = "LOAD DATA LOCAL INFILE '$path' INTO TABLE test.users FIELDS TERMINATED BY ',' $option LINES TERMINATED BY '\n' IGNORE 1 LINES;";
    $sql2 = "LOAD DATA LOCAL INFILE '$path2' INTO TABLE test.users FIELDS TERMINATED BY ',' $option LINES TERMINATED BY '\n' IGNORE 1 LINES;";

    $t0 = microtime_float();
    $mysqli->query($sql);
    $mysqli->query($sql2);
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $i--;

    $_SESSION['message'] = "'$i' utilisateurs ajoutés en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['addIndexOnType'])){

    $sql = "CREATE INDEX monIndex ON users (type);";

    $t0 = microtime_float();
    $mysqli->query($sql);
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $_SESSION['message'] = "Index ajoutés sur Type en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['addUnique'])){

    $sql = 'CREATE UNIQUE INDEX indexUnique ON users (email); CREATE INDEX indexSuppr ON users (supprime);';

    $t0 = microtime_float();
    $mysqli->multi_query($sql);
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $_SESSION['message'] = "Index ajoutés sur Email et Supprime en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['dropUnique'])){

    $sql = 'DROP INDEX indexUnique ON users;';

    $t0 = microtime_float();
    $mysqli->query($sql);
    $t1 = microtime_float();
    $time = $t1 - $t0;


    $_SESSION['message'] = "Index sur Email supprimé en '$time' secondes !";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['1m&index'])){

    $mysqli->query("TRUNCATE Table users");

    $sqlTab = array();
    array_push($sqlTab, array("id_users","type","adresse","nom", "supprime" ,"email"));
    $i = 0;
    while ($i <= 1000000)
    {
        $type = randomType();
        $adresse = randomAdresse();
        $name = randomName();
        $mail = randomMailv2();
        array_push($sqlTab, array($i,$type,$adresse,$name, "0" ,$mail));
        $i++;
    }

    $fp = fopen('fileTest.csv', 'w');
    foreach ($sqlTab as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);

    $path = "fileTest.csv";
    $option = "OPTIONALLY ENCLOSED BY '\"' ";
    $sqlInsert = "LOAD DATA LOCAL INFILE '$path' INTO TABLE test.users FIELDS TERMINATED BY ',' $option LINES TERMINATED BY '\n' IGNORE 1 LINES;";

    $sqlIndex = "CREATE UNIQUE INDEX indexUnique ON users (email);";


    $t0 = microtime_float();
        $mysqli->query($sqlInsert);
    $t0_5 = microtime_float();
        $mysqli->query($sqlIndex);
    $t1 = microtime_float();

    $timeTotal = $t1 - $t0;
    $timeInsert = $t0_5 - $t0;
    $timeIndex = $t1 - $t0_5;

    $i--;

    $_SESSION['message'] = "'$i' lignes ajouté en '$timeInsert' secondes, ajout de l'index sur email en '$timeIndex' secondes pour un total de '$timeTotal' secondes!";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['vider'])){

    $mysqli->query("TRUNCATE Table users");
    $_SESSION['message'] = "Table utilisateurs vidée!";
    header ("Refresh: 1;URL=index.php");

}


/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['select2000'])){



    $t0 = microtime_float();
    $mysqli->query("SELECT * FROM users WHERE supprime=0 AND type='1' LIMIT 2000");
    $t1 = microtime_float();
    $timeTotal = $t1 - $t0;

    $_SESSION['message'] = "select de 2000 lignes en '$timeTotal'";
    header ("Refresh: 1;URL=index.php");
}

/////////////////////////////////////////////////////////////////////////////////////////////
if(isset($_POST['count1mil'])){



    $t0 = microtime_float();
    $result = $mysqli->query("SELECT SUM(id_users) AS somme FROM (SELECT * FROM users WHERE supprime=0 LIMIT 1000000) AS user");
    $t1 = microtime_float();
    $timeTotal = $t1 - $t0;

    if(!$result) {
        $_SESSION['message'] = "erreur";
    }
    else{
        $row = $result->fetch_array();
        $somme = $row['somme'];
        $_SESSION['message'] = "La somme des premières 1 millions de ligne est de '$somme' executer en '$timeTotal' secondes";
    }


    header ("Refresh: 1;URL=index.php");
}