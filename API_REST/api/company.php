<?php
//TODO пустой запрос обработать параметров не хватает
//безопасность

spl_autoload_register(function ($class) {
	$classes = array("catalog" ,"phone");
	if (in_array( $class,$classes)) {
		include  $class . '.php';
	}
});

class company extends apiBaseClass {

	private $result;
	protected $db=null; 

	const TYPE_QUERY_FLEX = 2;
	const TYPE_QUERY_STRONG = 1;

	const TYPE_AREA_CIRCLE = 1;
	const TYPE_AREA_SQUARE = 2;
	const TYPE_AREA_RECT = 3;

	public function __construct($db)
	{
	// 	настройки подключения
		$this->db =$db;

	} 


	public function findByCat ($params) {
		try { 
			
			$st=$this->db->prepare("SELECT name FROM company INNER JOIN catalog_company ON company.id_c=catalog_company.id_c WHERE catalog_company.id_ca=:id_ca");  
			
			$id_ca =(isset($params->id_ca))? $params->id_ca: "";
			$st->bindParam(':id_ca', $id_ca, PDO::PARAM_INT);

			$result_exec= $st->execute ();

			$result = $this->createDefaultResponse($st);
		}
		catch(PDOException $e) {$result = $this->createJsonError();}

		return $result; 

	}

	//поиск организации по названию
	public function findByName($params) {

		try { 
			$st = $this->db->prepare("SELECT company.name,building.adress FROM building
				INNER JOIN company ON (building.id_b = company.id_b) where company.name LIKE CONCAT('%', :name, '%')");

			
			$name =(isset($params->name))? $params->name: "";

			$name=$this->escapeString($name);

			$st->bindParam(':name', $name, PDO::PARAM_STR);

			$result_exec=$st->execute ();

			$result = $this->createDefaultResponse($st);
		}  
		catch(PDOException $e) {$result = $this->createJsonError();}
		return $result; 
	}

	public function findByAdress ($params) {


		$adress =(isset($params->adress))? $params->adress: "";
		$id_type =(isset($params->id_type))? $params->id_type: "";

		//фильтр по белому списку ниже
		//поскольку устаовлено сопоставление ci, то операции с регистром можно не выполнять
		//$adress = strtolower($adress);
		//echo $adress;
		if ($id_type==self::TYPE_QUERY_FLEX) {
			//гибкий поиск
			//убрать пробелы и запятые

			$adress=str_replace(" ", "", $adress);
			$adress=str_replace("\\", "/", $adress);
			$adress=$this->escapeString($adress);

			$condition	="REPLACE(LOWER(building.adress), ' ', '') LIKE LOWER(CONCAT('%', :adress, '%'))";

		}
		else {
			
			$adress=$this->escapeString($adress);
			$condition="LOWER(building.adress)=LOWER(:adress)";
		}
		try { 
			$st = $this->db->prepare("SELECT name, adress FROM company INNER JOIN building ON company.id_b=building.id_b WHERE ".$condition);

			$st->bindParam(':adress', $adress, PDO::PARAM_STR);
			$result_exec=$st->execute ();
			
			$result = $this->createDefaultResponse($st);

		}  
		catch(PDOException $e) {$result = $this->createJsonError();}
		return $result; 	
	}

	//список организаций, которые находятся в заданном радиусе/прямоугольной
	//области относительно указанной точки на карте.
	public function findByCoord ($params) {

		$id_type =(isset($params->id_type))? $params->id_type: "";
		$num_x =(isset($params->num_x))? $params->num_x: "";
		$num_y =(isset($params->num_y))? $params->num_y: "";

		//$id_type =(double) $params->id_type;
		$num_x = (double) $num_x;
		$num_y = (double) $num_y;
		
		//круг	
		if ($id_type==self::TYPE_AREA_CIRCLE) {

			
			$num_R =(isset($params->num_R))? $params->num_R: "";
			$num_R =(double) $num_R;
			try { 
				$st =$this->db->query("SELECT company.name, building.x, building.y
					FROM building
					INNER JOIN company ON (building.id_b = company.id_b) WHERE POW(($num_x-building.x),2)+POW(($num_y-building.y),2)<=POW(($num_R),2)");
				$result = $this->createDefaultResponse($st);
			}  
			catch(PDOException $e) {$result = $this->createJsonError();}

		}
		//квадрат
		elseif ($id_type==self::TYPE_AREA_SQUARE) {
			$num_R =(double) $num_R;
			$num_R =(isset($params->num_R))? $params->num_R: "";
			//$num_R =$params->num_R;
			
			try { 
				$st = $this->db->query("SELECT company.name, building.x, building.y
					FROM building
					INNER JOIN company ON (building.id_b = company.id_b) WHERE

					($num_x+$num_R>=building.x) AND
					($num_x-$num_R<=building.x) AND
					($num_y+$num_R>=building.y) AND
					($num_y-$num_R<=building.y)");
				$result = $this->createDefaultResponse($st);

			}  
			catch(PDOException $e) {$result = $this->createJsonError();}

		}

		//прямоугольник
		elseif ($id_type==self::TYPE_AREA_RECT) {
			$num_x1 =(isset($params->num_x1))? $params->num_x1: "";
			$num_y1 =(isset($params->num_y1))? $params->num_y1: "";
			$num_x1 =(double)$num_x1;
			$num_y1 =(double)$num_y1;
			try { 
				$st = $this->db->query("SELECT company.name, building.x, building.y
					FROM building
					INNER JOIN company ON (building.id_b = company.id_b) WHERE

					(building.x<=$num_x1) AND
					(building.x>=$num_x-($num_x1-$num_x)) AND
					(building.y<=$num_y1) AND
					(building.y>=$num_y-($num_y1-$num_y))");
				$result = $this->createDefaultResponse($st);



			}  
			catch(PDOException $e) {$result = $this->createJsonError();}
		}

		else {$result = $this->createJsonError();}
		

		return $result; 

	}

	//выдача информации об организациях по их идентификаторам
	public function findByID ($params) {


		$id_c =(isset($params->id_c))? $params->id_c: "";
		
		try { 
			$st = $this->db->prepare("SELECT building.adress, company.name
				FROM  building
				INNER JOIN  company ON (building.id_b = company.id_b) where company.id_c=:id_c");

			$st->bindParam(':id_c', $id_c, PDO::PARAM_INT);
			$result_exec=$st->execute ();
			
			$result = $this->createDefaultResponse($st);
		}  
		catch(PDOException $e) {  
			$result = $this->createJsonError();
		}
		//Список телефонов
		$phones=new phone($this->db);

		$phones_list=$phones->getList($params);
		if ($phones_list!==false) {$result->items[0]->phones=$phones_list;}

 		//Path Breadcrumbs
		$catalog=new catalog($this->db);
		$path_breadcrumbs="";
		
		try { 
			$st = $this->db->prepare("SELECT id_ca
				FROM catalog_company INNER JOIN company
				ON (company.id_c = catalog_company.id_c) where company.id_c=:id_c");

			$st->bindParam(':id_c', $id_c, PDO::PARAM_INT);
			$result_exec=$st->execute ();

			$st->setFetchMode(PDO::FETCH_OBJ);
			
			while($item = $st->fetch())
			{

				$path=$catalog->getBreadcrumbs($item);

				if ($path!==false) {$path_breadcrumbs.= $path;};
			}

			$result->items[0]->path=$path_breadcrumbs;
		}  
		catch(PDOException $e) {$result = $this->createJsonError();}

		return $result; 
	}
}


?>


