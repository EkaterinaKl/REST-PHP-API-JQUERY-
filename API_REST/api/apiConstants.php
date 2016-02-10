<?php
class APIConstants {

    //Результат запроса - параметр в JSON ответе
    public static $RESULT_CODE="resultCode";
    
    //Ответ - используется как параметр в главном JSON ответе в apiEngine
    public static $RESPONSE="response";
    
    //Нет ошибок
    public static $ERROR_NO_ERRORS = 0;
    
    //Ошибка в переданных параметрах
    public static $ERROR_PARAMS = 1;
    public static $ERROR_PARAMS_TEXT = 1;
    
    //Ошибка в подготовке SQL запроса к базе
    public static $ERROR_STMP = 2;

    //Ошибка запись не найдена
    public static $ERROR_RECORD_NOT_FOUND = 3;
    
    
    //Ошибка выполнения запроса
    public static $ERROR_QUERY_EXEC = 4;
    public static $ERROR_QUERY_EXEC_TEXT = "Ошибка выполнения запроса";

        //Ошибка выполнения запроса
    public static $ERROR_DB_CONNECT = 5;
    public static $ERROR_DB_CONNECT_TEXT = "Ошибка подключения к БД";

    //Непредвиденное исключение
    public static $ERROR_ENGINE_UNINTENDED = 6;

    //Ошибка в параметрах запроса к серверу. 
    public static $ERROR_ENGINE_ROUTE = 100;
    public static $ERROR_ENGINE_ROUTE_TEXT =  "Неверный вызов API";    


    //Ошибка в параметрах запроса, переданных в метод
    public static $ERROR_ENGINE_PARAMS = 200;
    public static $ERROR_ENGINE_PARAMS_TEXT =  "Неверные параметры запроса к API";  
    
    //Параметры подключения базы
    public static $DB_NAME='katalog';
    public static $DB_HOST='127.0.0.1';
    public static $DB_USER='root';
    public static $DB_PASSWORD='';
   
}

?>