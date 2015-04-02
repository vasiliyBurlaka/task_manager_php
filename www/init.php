<?php

	$db = new SQLite3('memory.db');

	$db->exec('
	  CREATE TABLE task_list (
	  	id integer not NULL,
	  	parent_id integer not NULL,
	  	text varchar(200) NULL,
		checked integer NULL,
		type integer NULL,
	  	login varchar(100)
	  ) ;

		CREATE TABLE users (
	  		login varchar(100),
			pass  varchar(100)
		);

	');

//	echo $db->lastErrorMsg();

?>