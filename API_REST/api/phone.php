<?php
class phone {

	private $result;
	protected $db=null; 

	public function __construct($db)
	{
	// 	настройки подключения
		$this->db =$db;
	} 

	public function getList ($params) {
		try { 
			$st = $this->db->prepare("SELECT phone.name
				FROM (company
					INNER JOIN company_phone
					ON (company.id_c = company_phone.id_c))
			INNER JOIN phone ON (phone.id_ph = company_phone.id_ph) where company.id_c=:id_c");

			$id_c =(isset($params->id_c))? $params->id_c: "";
			
			$st->bindParam(':id_c', $id_c, PDO::PARAM_INT);
			$result_exec=$st->execute ();

			$st->setFetchMode(PDO::FETCH_NUM);
			$phones="";
			while($item = $st->fetch()) {  
				$phones.=$item [0] . "<br>";  
			}
			$result=$phones;
		}  
		catch(PDOException $e) {$result = false;}
		return $result;
	}
}