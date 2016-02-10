<?php
class apiBaseClass {


    //Создаем дефолтный JSON для ответов
    function createDefaultResponse($st) {
        $retObject = json_decode('{}');

        $st->setFetchMode(PDO::FETCH_OBJ);
        $items = $st->fetchAll();//если эканировать вывод, то делать выборку по записям
        $row_num=count($items);
        $retObject->result =true ;
        $retObject->count = "Найдено записей: ".$row_num;
        $retObject->items=$items;

        return $retObject;
    }

        //Создаем дефолтный JSON для ошибки
    function createJsonError() {
        $retObject = json_decode('{}');

        $retObject->result = false;
        $retObject->errorno = APIConstants::$ERROR_QUERY_EXEC;
        $retObject->error = APIConstants::$ERROR_QUERY_EXEC_TEXT;
        
        return $retObject;
    }
    

    protected function escapeString($var)
    {



        //обработка строковых данных
        $var = trim($var); 
        // $var = strip_tags($var); //используется при выводе
        //$var = htmlspecialchars($var);//используется при выводе
        $var = (!get_magic_quotes_gpc()) ? addslashes($var) : $var;
        //оставляем из спецсимволов: "", /,-, !, ? т.к. может входить в адрес и название организации
        $pattern = '/([^a-zа-яё0-9!\?\+-, "\/])/iu';
        $replacement=NULL;
        $var=preg_replace($pattern, $replacement, $var);
        return $var;


    }  
    //Заполняем JSON объект по ответу из DBEngine

}

?>