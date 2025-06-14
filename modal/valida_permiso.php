	<?php
		if (isset($con))
		{
			//* valida permiso a Menu e Item del Menu
			$sql="select * from acceso t1, menu_item t2, menu t3 where t1.perfil_id=".$user_perfil_id." and t1.menu_item_id=t2.menu_item_id and t2.menu_id=t3.menu_id and t3.menu_estado=1 and t2.menu_item_estado=1 and t3.menu_cod='".$menu_cod."' and t2.menu_item_cod='".$menu_item_cod."'";	
	
			$query=mysqli_query($con, $sql);
			$count=mysqli_num_rows($query);
				if ($count==0)
				{    
					header("location: inicio.php");
					exit;
				}

		}
	?>