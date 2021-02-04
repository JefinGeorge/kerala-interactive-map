<?php
$cid=$_GET['ac_id'];
$stack = array();
$master = array();
if(empty($cid)){
    exit();
}

    $db_username ='*******';
    $db_pwd='*******';
    $dsn  = 'mysql:host=localhost;dbname=*******';
    
    try {
     $pdo  = new PDO($dsn, $db_username, $db_pwd);
    } 
    catch (PDOException $e) {
     echo "Connection failed: " . $e->getMessage();
     exit;
    }

    $stmt = $pdo->prepare("select * FROM candidates WHERE constituency=:constituency ORDER BY priority ASC");
    $stmt->execute(['constituency' => $cid]); 
    while ($row = $stmt->fetch()) {
        $stack['id'] = $row['id'];
        $stack['name'] = $row['name'];
        $stack['constituency'] = $row['constituency'];
        $stack['priority'] = $row['priority'];
        $stack['image'] = $row['image'];
        
        array_push($master, $stack);
        $stack= array();
    }
    $pdo = null;
    $netJSON = json_encode($master);
    echo $netJSON;
?>