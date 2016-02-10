<?php
class catalog extends apiBaseClass {

	private $result;
	protected $db=null; 

	public function __construct($db)
	{
	// 	настройки подключения
		$this->db =$db;

	} 

	protected	function getTreeFromTo($left_key, $right_key) {

		try { 
			$result = $this->db->query("SELECT catalog.name, catalog.level,catalog.id_ca
				FROM catalog
				where id_left_key >= $left_key AND id_right_key <= $right_key ORDER BY id_left_key");
		}  
		catch(PDOException $e) {$result =false;}

		return $result;
		
	}

	protected function getBounds($params) {

		try {

			if(!empty($params->id_ca)) {

				$st = $this->db->prepare("SELECT catalog.id_right_key,  catalog.id_left_key
					FROM catalog
					WHERE id_ca=:id_ca");

				$id_ca =$params->id_ca;
				$st->bindParam(':id_ca', $id_ca, PDO::PARAM_INT);

				$result_exec= $st->execute ();
			}
			else {
				$st = $this->db->query("SELECT catalog.id_right_key,  catalog.id_left_key
					FROM catalog
					WHERE catalog.id_left_key=1");
			}

			$st->setFetchMode(PDO::FETCH_OBJ);
			$item = $st->fetch();
			$result=$item;
		}  
		catch(PDOException $e) {$result =false;}
		//вернуть набор запсией или пустой объект
		return $result;
	}

	public function getBreadcrumbs($params) {
		$bounds=$this->getBounds($params);

		if ($bounds!==false) {
			try {
				$st = $this->db->query("SELECT catalog.name
					FROM catalog
					where id_left_key <= ".$bounds->id_left_key." AND id_right_key >= ".$bounds->id_right_key." ORDER BY id_left_key");

				$path="";
				
				$st->setFetchMode(PDO::FETCH_OBJ);
				while($item = $st->fetch())
				{
					$path.=$item->name." / ";
				}

				$path=substr($path, 0, -2) ;
				$path.="<br>";
				$result=$path;
			}
			catch(PDOException $e) {$result =false;}
		}
		else {
			$result = false;
		}

		return $result;
		
	}

	public function getTree($params) {

		$bounds=$this->getBounds($params);

		if ($bounds!==false) {
			$st=$this->getTreeFromTo($bounds->id_left_key,$bounds->id_right_key);
			if ($st!==false) {

			//проще 1 if, чтобы меньше времени тратилось на проверку
				$st->setFetchMode(PDO::FETCH_OBJ);

				$tree="<ul>";
				$parent=0;

				while($item = $st->fetch())
				{

					$fork="<li><a href='#' id=".$item->id_ca.">".$item->name."</a></li>";
					if ($parent<$item->level){$fork="<ul>$fork"; } 
					if ($parent>$item->level){$fork="</ul>$fork";}
					$tree.="$fork";
					$parent=$item->level;	
				}
				$tree.="</ul>";

				$tree_as_array=(object) array('tree' => $tree);
				$result = (object) array('result' => true ,'items'=>array($tree_as_array));
				
			}
			else {

				$result = $this->createJsonError();
			}	
		}
		else {
			$result = $this->createJsonError();
		}


		return $result;
	}

}


?>


