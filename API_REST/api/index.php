<?php
header('Content-type: text/html; charset=UTF-8');

error_reporting(0);
require_once 'apiEngine.php';
if (count($_REQUEST)>0){

	$db=DBEngine::getInstance(APIConstants::$DB_NAME,APIConstants::$DB_HOST,
		APIConstants::$DB_USER,APIConstants::$DB_PASSWORD);
	if (!is_null($db)) {
		foreach ($_REQUEST as $apiFunctionName => $apiFunctionParams) {
			$APIEngine=new APIEngine($apiFunctionName,$apiFunctionParams, $db);

        // http://[адрес сервера]/[путь к папке api]/?[название_api].[название_метода]=[JSON вида {«Hello»:«Hello world»}]
         //?company.getList={"id_ca":5}
			echo $APIEngine->callApiFunction(); 
			unset ($apiEngin);
			break;           

		}


	}
	else{
		$jsonResult = json_decode('{}');
		$jsonResult->response = json_decode('{}');
		$jsonResult->response->result= false;
		$jsonResult->response->error = APIConstants::$ERROR_DB_CONNECT_TEXT;
		$jsonResult->response->errorno = APIConstants::$ERROR_DB_CONNECT;

		echo json_encode($jsonResult);
	}
}
else{
	$jsonResult = json_decode('{}');
	$jsonResult->response = json_decode('{}');
	$jsonResult->response->result= false;
	$jsonResult->response->error = APIConstants::$ERROR_ENGINE_ROUTE_TEXT;
	$jsonResult->response->errorno = APIConstants::$ERROR_ENGINE_ROUTE;

	echo json_encode($jsonResult);
}
?>