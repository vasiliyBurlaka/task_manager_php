<?php
session_start();
if (!file_exists('memory.db')) {
	include 'init.php';
}


if ($_REQUEST['act']=='get_todo_list') {
	$tpl = getListTpl('You can change it...');

	$data = array(
		'status' => $tpl ? 'ok' : 'error',
		'tpl' => $tpl
	);

	$result = json_encode($data);
} elseif ($_REQUEST['act']=='get_task') {
	$tpl = getTaskTpl($_REQUEST['name']);

	$data = array(
		'status' => $tpl ? 'ok' : 'error',
		'tpl' => $tpl
	);
	$result = json_encode($data);
} elseif ($_REQUEST['act']=='saveData') {

	$db = new SQLite3('memory.db');

	$login = $_SESSION['login'];
	$db->exec("DELETE FROM task_list where login = '$login';");
	$db->exec("VACUUM;");
	foreach($_REQUEST['data'] as $number => $list) {
		$text = str_replace(array("'", "<", ">"), array("&apos;", "&lt;", "&gt;"), $list['list_name']);
		$query = "INSERT into task_list VALUES (" . (integer)$number . "," . (integer)$number . ", '" .$text . "', NULL, 0, '$login');";
		$db->exec($query);

		foreach($list['tasks'] as $key=>$task) {
			$checked = $task['checked']=='true' ? 1 : 0;
			$text = str_replace(array("'", "<", ">"), array("&apos;", "&lt;", "&gt;"), $task['text']);
			$query = "INSERT into task_list VALUES (" .(integer)$key . ", ". (integer)$number . ", '" .$text . "', " . $checked . ",1, '$login');";
			$db->exec($query);
		}
	}
//	$result['status'] = 'ok';
} elseif ($_REQUEST['act']=='load') {
	$db = new SQLite3('memory.db');
	$login = $_SESSION['login'];
	$query = "select * from task_list where login = '$login' order by parent_id, type, id;";

	$results = $db->query($query);
	$prj = '';
	$result = '';

	while ($row = $results->fetchArray()) {
		$text = str_replace("&apos;", "'", $row['text']);
		$text = str_replace("&", "&amp;", $text);

		if ($row['type']==0) {
			$result .= $prj;
			$prj = getListTpl($text, true);
		} else {
			$task = getTaskTpl($text, $row['checked']) . '{tasks}';
			$prj = str_replace('{tasks}', $task, $prj);
		}
	}
	$result .= $prj;
	$result = str_replace('{tasks}', '', $result);
} elseif ($_REQUEST['act']=='login') {
	$db = new SQLite3('memory.db');
	$query = "select pass from users where login = '{$_REQUEST['login']}';";
	$results = $db->query($query);
	$data = array();
	$row = $results->fetchArray();

	if (!empty($row['pass']) && md5($_REQUEST['pass'])!=$row['pass']) {
		$data['status'] = 'error';
		$data['description'] = 'wrong password';
	} elseif(!empty($row['pass']) && md5($_REQUEST['pass'])==md5($row['pass'])) {
		$data['status'] = 'ok';
		session_start();
		$_SESSION['login'] = $_REQUEST['login'];
		session_write_close();
	} else {
		$query = "insert into users VALUES ('{$_REQUEST['login']}' , '" . md5($_REQUEST['pass']) . "');";
		$db->query($query);
		$data['status'] = 'ok';
		session_start();
		$_SESSION['login'] = $_REQUEST['login'];
		session_write_close();
	}
	echo '';
	$result = json_encode($data);
} elseif ($_REQUEST['act']=='logout') {
	session_unset();
	$result = json_encode(array('status' => 'ok'));
}

die($result);

function getListTpl($name, $put_tasks = false) {
	$result = file_get_contents('lib/template/todolist.tpl');
	$result = str_replace('{name_of_list}', $name, $result);
	if (!$put_tasks) {
		$result = str_replace('{tasks}', '', $result);
	}

	return $result;
}

function getTaskTpl($name, $checked='') {
	$result = file_get_contents('lib/template/task.tpl');
	$result = str_replace('{task_name}', $name, $result);
	$result = str_replace('{task_checked}', ($checked ? 'checked="checked"' : ''), $result);
	return $result;
}

?>