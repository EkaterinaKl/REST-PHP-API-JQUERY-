<?php 

$count_errors=0;

foreach( $_POST as $field => $val)
{

	if(isset($_POST[$field])){$$field = $val;

		
		if($$field==''){unset($$field);
			continue;

		}


	}

	if (strpos($field,"id") !== false) {
		
		if (!is_numeric($val)) {


			$count_errors++;}

			$$field = (int) $$field;
			continue;
		}
		if (strpos($field,"num") !== false) {
			if (!is_numeric($val)) {


				$count_errors++;
	
			}$$field+=0;
		//проверка целого нужна
			$$field = (double) $$field;
			continue;
			
		}
		if(isset($$field)) {

			$$field = trim($$field); 
			$$field = strip_tags($$field); 
			$$field = htmlspecialchars($$field);
		
		//рекомендуетсяисопльзовать prepareStatement
		//неоптимально - экранировать перед выполненеим 
		//или ключ на обработку
			if ((strpos($field,"adress") === false) and (strpos($field,"name") === false)) {
				
				$$field= stripslashes($$field);
				$$field = $conn->quote($$field);
			}			


		} else {$count_errors++;};


	}
	
	unset($_GET);
	unset($_POST);

	?>
