<?php

class building extends apiBaseClass {

    private $result;
    protected $db=null; 


    public function __construct($db)
    {
    //  настройки подключения
        $this->db =$db;

    } 
    //список зданий
    public function findBuildings () {
       try { 
        $st = $this->db->query("SELECT adress as name FROM building ORDER BY name");
        $result = $this->createDefaultResponse($st);
    }  
    catch(PDOException $e) {$result = $this->createJsonError();}

    return $result; 

}
}

?>