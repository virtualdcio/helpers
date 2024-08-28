<?php

$db_host = "localhost"; // сервер
$db_user = "pdns"; // имя пользователя
$db_pass = "pUtreC6S!@#"; // пароль
$db_name = "pdns"; // название базы данных

$db = new mysqli($db_host, $db_user, $db_pass, $db_name);

// проверка на успешное подключение и вывод ошибки, если оно не выполнено
if ($db->connect_error) {
	echo "Нет подключения к БД. Ошибка:".mysqli_connect_error();
	exit;
}
$test = 0; // изменить значение на 0 если нужно удалять записи, изменить значение на 1 если удалять не нужно
$verbose = 0; // изменит значение на 1 для вывода списка доменов (вывод поля  domainnames которые будут уадлены или не удалены (настройка переменной $test)

// ищем и выполняем...

	function is_stil_active($domain,$server){
		$axfr = shell_exec("dig AXFR ".$domain." @".$server."");
		$explode = explode("XFR size:",$axfr);
		if(isset($explode['1'])){
			return TRUE;
		}else{
			return FALSE;
		}
	}

$sql3 = "SELECT `id`,`name`,`master` FROM domains WHERE `type`='SLAVE'";
$query = $db->query($sql3) or die($db->error());
if(mysqli_num_rows($query) == FALSE){
}else{
	while($record = mysqli_fetch_object($query)){
		if(!is_stil_active($record->name,$record->master)){
			if($test === 0){
				$db->query("DELETE FROM domains WHERE id='".$record->id."'") or die($db->error());
				$db->query("DELETE FROM records WHERE domain_id='".$record->id."'") or die($db->error());
			}
			if($verbose === 1){
				echo $record->name."". PHP_EOL;
			}
		}
	}
	if($verbose === 1){
		echo "Готово!". PHP_EOL;
	}
}
$db->close();
?>
