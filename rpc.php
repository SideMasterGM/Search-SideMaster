<p id="searchresults">
<?php
	$db = new mysqli('127.0.0.1', 'SideMaster', 'Programador', 'search');
	if(!$db) {
		echo 'ERROR: Could not connect to the database.';
	} else {
		// Is there a posted query string?
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			
			// Is the string length greater than 0?
			if(strlen($queryString) >0) {
				$query = $db->query("SELECT * FROM search s INNER JOIN categories c ON s.cat_id = c.cid WHERE name LIKE '%" . $queryString . "%' ORDER BY cat_id LIMIT 8");
				
				if($query) {
					$catid = 0;
					while ($result = $query ->fetch_object()) {
						if($result->cat_id != $catid) { // check if the category changed
							echo '<span class="category">'.$result->cat_name.'</span>';
							$catid = $result->cat_id;
						}
	         			echo '<a href="'.$result->url.'">';
	         			echo '<img src="search_images/'.$result->img.'" alt="" />';
	         			
	         			$name = $result->name;
	         			if(strlen($name) > 35) { 
	         				$name = substr($name, 0, 35) . "...";
	         			}	         			
	         			echo '<span class="searchheading">'.$name.'</span>';
	         			
	         			$description = $result->desc;
	         			if(strlen($description) > 80) { 
	         				$description = substr($description, 0, 80) . "...";
	         			}
	         			
	         			echo '<span>'.$description.'</span></a>';
	         		}
	         		echo '<span class="seperator"><a href="http://www.ceodevelopers.com/sitemap.php" title="Mapa del sitio">¿Nada interesante aquí? Pruebe el mapa del sitio.</a></span><br class="break" />';
				} else {
					echo 'ERROR: Hubo un problema con la consulta.';
				}
			} else {
				// Dont do anything.
			} // There is a queryString.
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>
</p>