<?php
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

	$db->exec("DELETE FROM task_list;");
	$db->exec("VACUUM;");

	foreach($_REQUEST['data'] as $number => $list) {
		$text = str_replace("'", "&apos;", $list['list_name']);
		$query = "INSERT into task_list VALUES (" . (integer)$number . "," . (integer)$number . ", '" .$text . "', NULL, 0);";
		$db->exec($query);

		foreach($list['tasks'] as $key=>$task) {
			$checked = $task['checked']=='true' ? 1 : 0;
			$text = str_replace("'", "&apos;", $task['text']);
			echo $text;
			$query = "INSERT into task_list VALUES (" .(integer)$key . ", ". (integer)$number . ", '" .$text . "', " . $checked . ",1);";
			$db->exec($query);
		}
	}
//	$result['status'] = 'ok';
} elseif ($_REQUEST['act']=='load') {
	$db = new SQLite3('memory.db');
	$query = "select * from task_list order by parent_id, type, id;";

	$results = $db->query($query);
	$prj = '';
	$result = '';

	while ($row = $results->fetchArray()) {
		$text = str_replace("&apos;", "'", $row['text']);
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