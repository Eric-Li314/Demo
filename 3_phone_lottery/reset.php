<?php
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'reset'){
    require_once 'db.class.php';
    $db = new DB();
    $db->update('member',array("status"=>'0'),"id>=0");
    echo $db->getAffectedRows()?"ok":'';
}