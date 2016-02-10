<?php
require_once ('apiConstants.php');
require_once ('DBEngine2.php');

class APIEngine {

    private $apiFunctionName;
    private $apiFunctionParams;
    protected $db;

    //Статичная функция для подключения API из других API при необходимости в методах
    static function getApiEngineByName($apiName, $db) {
        require_once 'apiBaseClass.php';
        require_once $apiName . '.php';
        $apiClass = new $apiName($db);
        return $apiClass;
    }
    
    //Конструктор
    //$apiFunctionName - название API и вызываемого метода в формате apitest_helloWorld
    //$apiFunctionParams - JSON параметры метода в строковом представлении
    function __construct($apiFunctionName, $apiFunctionParams,$db) {
       
        $this->apiFunctionParams =$apiFunctionParams;

        //Парсим на массив из двух элементов [0] - название API, [1] - название метода в API
        $this->apiFunctionName = explode('_', $apiFunctionName);
        $this->db=$db;
    }

    //Создаем JSON ответа
    function createDefaultJson() {
        $retObject = json_decode('{}');
        $response = APIConstants::$RESPONSE;
        $retObject->$response = json_decode('{}');
        return $retObject;
    }
    
    //Вызов функции по переданным параметрам в конструкторе
    function callApiFunction() {
        $jsonResult = $this->createDefaultJson();//Создаем JSON  ответа
        $apiName = strtolower($this->apiFunctionName[0]);//название API проиводим к нижнему регистру

        if (file_exists($apiName . '.php')) {
            $apiClass = APIEngine::getApiEngineByName($apiName, $this->db);//Получаем объект API
            $apiReflection = new ReflectionClass($apiName);//Через рефлексию получем информацию о классе объекта
            try {
                $functionName = $this->apiFunctionName[1];//Название метода для вызова
                $apiReflection->getMethod($functionName);//Провераем наличие метода
                $response = APIConstants::$RESPONSE;

                $jsonParams = json_decode($this->apiFunctionParams);//Декодируем параметры запроса в JSON объект

                if ($jsonParams) {

                         $jsonResult->$response = $apiClass->$functionName($jsonParams);//Вызыаем метод в API который вернет JSON обект

                     } else {
                    //Если ошибка декодирования JSON параметров запроса
                        $jsonResult->response->result= false;
                        $jsonResult->response->errno = APIConstants::$ERROR_ENGINE_PARAMS;
                        $jsonResult->response->error = APIConstants::$ERROR_ENGINE_PARAMS_TEXT;
                    }
                } catch (Exception $ex) {
                //Непредвиденное исключение
                  $jsonResult->response->result= false;
                  $jsonResult->response->errno = APIConstants::$ERROR_ENGINE_UNINTENDED;
                  $jsonResult->response->error = $ex->getMessage();
              }
          } else {
            //Если запрашиваемый API не найден

            $jsonResult->result= false;
            $jsonResult->errno = APIConstants::$ERROR_ENGINE_ROUTE;
            $jsonResult->error = APIConstants::$ERROR_ENGINE_ROUTE_TEXT;
        }
        return json_encode($jsonResult);

    }
}

?>
