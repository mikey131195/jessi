<?php
session_start();
include 'db_open.php';
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ITESM - Sistema de Calendarización</title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
	
	<?php
	$sql="SELECT * FROM admin WHERE admin_user='".@$_SESSION['adusername']."' AND admin_pass='".@$_SESSION['adpassword']."'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
	if($count>=1){
	?>

	<table align="center" class="AdminSystem" width="600" border="0" cellspacing="0" cellpadding="0">
    <tr height="50"><td></td></tr>
    <tr><td><b><font color="#006699">SISTEMA DE CALENDARIZACIÓN</font></b></td></tr>
    <tr height="20"><td></td></tr>
    <tr><td><b><font color="#000000">[ REPORTES - PROFESORES > HORARIOS DISPONIBLES ]</font></b></td></tr>
    <tr height="50"><td></td></tr>
    <tr><td>
            <?php
			$query_aux  = "SELECT * FROM profesor WHERE Profesor_Id ='".@$_GET['id']."'";
			$result_aux = mysql_query($query_aux);
			$row_aux = @mysql_fetch_array($result_aux, MYSQL_ASSOC);
			echo "<div style='font-size:15px; font-weight:bold'>Profesor: &nbsp;".$row_aux['Profesor_Nombre']."</div><br/><br/>";
			$query_aux  = "SELECT * FROM hora";
			$result_aux = mysql_query($query_aux);
			$str = "";
			while ($row_aux = @mysql_fetch_array($result_aux, MYSQL_ASSOC)){
				$str = $str.substr($row_aux['Hora_Nombre'],0,-2).":".substr($row_aux['Hora_Nombre'],-2).",";
			}
			$stack = explode(",",$str);
			
			$query  = "SELECT * FROM horarios_disp LEFT JOIN profesor_horario ON profesor_horario.Horario_Disp_Id = horarios_disp.Horario_Disp_Id LEFT JOIN dia ON horarios_disp.Dia_Id = dia.Dia_Id WHERE profesor_horario.Profesor_Id = ".$_GET["id"];
			$result = mysql_query($query);
			$count=mysql_num_rows($result);
			if($count>=1){
			echo "<table width='100%' border='1'>";
			echo "<tr><td><b>DÍA</b></td><td><b>HORA INICIAL</b></td><td><b>HORA FINAL</b></td></tr>";	
			while ($row = @mysql_fetch_array($result, MYSQL_ASSOC)) {
				echo "<tr><td>".@$row['Dia_Nombre']."</td><td>".$stack[@$row['Hora_Inicio']-1]."</td><td>".$stack[@$row['Hora_Fin']-1]."</td></tr>";
			}
			echo "</table><br />";
			} else {
			echo "<br><b>No existen horarios registrados para el profesor.</b>";
			}
			@mysql_free_result($result); 
			?>        
    </td></tr>
    <tr height="20"><td></td></tr>
    <tr><td colspan="2"><a href="profesores.php">REGRESAR</a></td></tr>
    <tr height="30"><td></td></tr>
    </table>
    
   	<?php
	} else {
	?>
    
	<table class="LoginBar" width="225" border="0" cellspacing="0" cellpadding="0">
    <tr><td><font color="#FF0000">ERROR DE ACCESO</font></td></tr>
    <tr height="10"><td colspan="2"></td></tr>
    <tr><td><a href="index.php">REGRESAR</a></td></tr>
    </table>
    
    <?php
	}
	?>

</body>
</html>

<?php
include 'db_close.php';
?> 