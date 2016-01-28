<?php

error_reporting(E_ALL);

//подключение к БД
include ("db.php");

//проверка и защита вводимых данных
include ("validate.php");

//isset - проверка всех значений
//обработка ошибок в pdo
//!сообщение об ошибке
//обернуть в интерфейс
//производительность?
// внешние ключи !!!новый Damp
//query на numrow
//проерка по беломи списку одного поля
//описать api 

// api http://webonrails.ru/post/208650773725188702/

if ($count_errors>0) {
	//TODO можно фиксировать переменные в которых ошибка
	$obj = (object) array('result' => false,'error' => "Неверные входные данные" );
	echo json_encode($obj); 
	exit;	
}

//выдача всех организаций находящихся в конкретном здании


const TYPE_FLEX = 2;
const TYPE_STRONG = 1;

const TYPE_CIRCLE = 1;
const TYPE_SQUARE = 2;
const TYPE_RECT = 3;


if (isset($adress)) {findByAdress($adress);}

function findByAdress ($adress) {
	global $conn;
//фильтр по белому списку
	$adress = strtolower($adress);

	if ($id_type==TYPE_FLEX) {
//гибкий поиск
//убрать пробелы и запятые

		$adress=str_replace(" ", "", $adress);
		$adress=str_replace("\\", "/", $adress);
	//	$adress = preg_replace("/[^a-zа-яё0-9\/]/", "", $adress); 
		$adress = mb_ereg_replace("/[^a-zа-яё0-9/]/", "", $adress);

		$condition	="REPLACE(LOWER(building.adress), ' ', '') LIKE CONCAT('%', '$adress', '%')";

	}
	else {
//точное соответсвие
//фильтр по белому списку
		$adress = mb_ereg_replace("/[^a-zа-яё0-9\/,-\.]/", "", $adress);
		//$adress =preg_replace("/[^a-zа-яё0-9\/,-\.]/", "", $adress);
		$condition="LOWER(building.adress)='$adress'";

	}

	$select = $conn->query("SELECT name, adress FROM company INNER JOIN building ON company.id_b=building.id_b WHERE $condition");

	$select->setFetchMode(PDO::FETCH_OBJ);
	$items = $select->fetchAll();
	$row_num=count($items);

	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);
	echo json_encode($obj); 
	unset($items);

}


if (isset($id_ca) && !isset($action)) {findByCat($id_ca, "");}


//список всех организаций, которые относятся к указанной рубрике


function findByCat ($id_ca, $action) {
	global $conn;
	$select = $conn->query("SELECT name FROM company INNER JOIN catalog_company ON company.id_c=catalog_company.id_c WHERE catalog_company.id_ca=$id_ca");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$items = $select->fetchAll();
	$row_num=count($items);
	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);
	echo json_encode($obj); 
	unset($items);

}

if (isset($num_x) && isset($num_y) ) {findByCoord($num_x, $num_y, @$num_R, @$num_x1, @$num_y1,$id_type); }

//список организаций, которые находятся в заданном радиусе/прямоугольной области относительно указанной точки на карте.
function findByCoord ($num_x, $num_y, $num_R, $num_x1, $num_y1,$id_type) {

	global $conn;	
	if (!isset($num_R)) {$num_R=0;};
	if (!isset($num_x1)) {$num_x1=$num_x;};
	if (!isset($num_y1)) {$num_y1=$num_y;};

	if ($id_type==TYPE_CIRCLE) {
//круг

		$select = $conn->query("SELECT company.name, building.x, building.y
			FROM building
			INNER JOIN company ON (building.id_b = company.id_b) WHERE POW(($num_x-building.x),2)+POW(($num_y-building.y),2)<=POW(($num_R),2)");
		$select->setFetchMode(PDO::FETCH_OBJ);

	}
	if ($id_type==TYPE_SQUARE) {
//квадрат
		$select = $conn->query("SELECT company.name, building.x, building.y
			FROM building
			INNER JOIN company ON (building.id_b = company.id_b) WHERE

			($num_x+$num_R>=building.x) AND
			($num_x-$num_R<=building.x) AND
			($num_y+$num_R>=building.y) AND
			($num_y-$num_R<=building.y)");
		$select->setFetchMode(PDO::FETCH_OBJ);


	}

	if ($id_type==TYPE_RECT) {
//прямоугольник

		$select = $conn->query("SELECT company.name, building.x, building.y
			FROM building
			INNER JOIN company ON (building.id_b = company.id_b) WHERE

			(building.x<=$num_x1) AND
			(building.x>=$num_x-($num_x1-$num_x)) AND
			(building.y<=$num_y1) AND
			(building.y>=$num_y-($num_y1-$num_y))");


		$select->setFetchMode(PDO::FETCH_OBJ);

	}

	$items = $select->fetchAll();
	$row_num=count($items);
	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);
	echo json_encode($obj); 
	unset($items);
}


//список зданий
if (isset($action) && $action=="'list'") { findBuildings($action);}

function findBuildings ($action) {
	global $conn;
	$select = $conn->query("SELECT adress as name FROM building ORDER BY name");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$items = $select->fetchAll();
	$row_num=count($items);
	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);
	echo json_encode($obj); 
	unset($items);
}

//поиск организации по названию
if (isset($name)) {findByName($name);}

function findByName($name) {
	global $conn;
	
	//$name = mb_ereg_replace("/[^a-zа-яё0-9/]/", "", $name);

	$select = $conn->query("SELECT company.name,building.adress FROM building
		INNER JOIN company ON (building.id_b = company.id_b) where company.name LIKE CONCAT('%', '$name', '%')");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$items = $select->fetchAll();
	$row_num=count($items);
	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);
	echo json_encode($obj); 
	unset($items);
}

//выдача информации об организациях по их идентификаторам
if (isset($id_c)) {findByID($id_c);}
function findByID ($id_c) {
	global $conn;

	$select = $conn->query("SELECT building.adress, company.name
		FROM  building
		INNER JOIN  company ON (building.id_b = company.id_b) where company.id_c=$id_c");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$items = $select->fetchAll();
	$row_num=count($items);
	$obj = (object) array('result' => true , 'count' => "Найдено записей: ".$row_num, 'items'=>$items);

	unset($items);

//Список телефонов
	$select = $conn->query("SELECT phone.name
		FROM (company
			INNER JOIN company_phone
			ON (company.id_c = company_phone.id_c))
	INNER JOIN phone ON (phone.id_ph = company_phone.id_ph) where company.id_c=$id_c");
	$select->setFetchMode(PDO::FETCH_NUM);
	$phones="";
	while($item = $select->fetch()) {  
		$phones.=$item [0] . "<br>";  
	}
	unset($item);

//$phones = implode("; ", $items);
	$obj->items[0]->phones=$phones;

 //Path Breadcrumbs
	$path="";
	$select = $conn->query("SELECT catalog.id_ca,  catalog.id_right_key,  catalog.id_left_key
		FROM ( catalog
			INNER JOIN  catalog_company
			ON (catalog.id_ca = catalog_company.id_ca))
	INNER JOIN company
	ON (company.id_c = catalog_company.id_c) where company.id_c=$id_c");
	$select->setFetchMode(PDO::FETCH_OBJ);
	$path.="";
	while($item = $select->fetch())
	{
		$right_key=$item->id_right_key;
		$left_key=$item->id_left_key;
		$subselect = $conn->query("SELECT catalog.name
			FROM catalog
			where id_left_key <= $left_key AND id_right_key >= $right_key ORDER BY id_left_key");
		$subselect->setFetchMode(PDO::FETCH_OBJ);
		$subitem = $subselect->fetch();

		while($subitem = $subselect->fetch())
		{
			$path.=$subitem->name." / ";
		}
		unset($subitem);
		$path=substr($path, 0, -2) ;
		$path.="<br>";

	}

	$obj->items[0]->path=$path;

	echo json_encode($obj);
	unset($item);
	unset($obj);
	unset($select);
	unset($subselect);
	unset($path);
	unset($left_key);
	unset($right_key);
}

//дерево рубрик каталога со всеми предками

//Adjacency List («список смежности») :   //  Materialized Path («материализованный путь») : //Closure Table («таблица связей»)
//Nested Sets («вложенные множества») - иерархические данные обычно очень редко меняются, но часто запрашиваются. 	 По скорости работы выборок им нет равных, да и запросы выходят проще и нагляднее, даже в случае сложных выборок.

//TODO можно доставлять массив данных и обрабатывать его на клиенте при помощи jsTree


if (isset($action)) {

	if ($action=="'getTree'") {
		if (isset($id_ca)) {
			getTree($action, $id_ca );
		} else {getTree($action,null);}
	}};

	function getTree($action, $id_ca ) {
		global $conn;

		if (isset($id_ca)) {


			$select = $conn->query("SELECT catalog.id_ca,  catalog.id_right_key,  catalog.id_left_key
				FROM catalog
				WHERE catalog.id_ca=$id_ca");


			if ($select->rowCount()==0 ) {

				$obj = (object) array('result' => false ,'error'=>'Нет записей');
				echo json_encode($obj); 
				exit;};

				$select->setFetchMode(PDO::FETCH_OBJ);
				$item = $select->fetch();
				$right_key=$item->id_right_key;
				$left_key=$item->id_left_key;
				$select = $conn->query("SELECT catalog.name, catalog.level,catalog.id_ca
					FROM catalog
					where id_left_key >= $left_key AND id_right_key <= $right_key ORDER BY id_left_key");

			}
			else 
			{
				$select = $conn->query("SELECT catalog.name, catalog.level, catalog.id_ca
					FROM catalog 
					ORDER BY id_left_key");
			}


			$tree="<ul>";

			$select->setFetchMode(PDO::FETCH_OBJ);
			$parent=0;
			while($item = $select->fetch())
			{
				$fork="<li><a href='#' id=".$item->id_ca.">".$item->name."</a></li>";
				if ($parent<$item->level){$fork="<ul>$fork"; } 
				if ($parent>$item->level){$fork="</ul>$fork";}
				$tree.="$fork";
				$parent=$item->level;	
			}
			$tree.="</ul>";



			$tree_as_array=(object) array('tree' => $tree);
			$obj = (object) array('result' => true ,'items'=>array($tree_as_array));

			echo json_encode($obj); 
		}


		flush();
		?>
