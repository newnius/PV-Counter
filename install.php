<?php
	require_once('util4p/util.php');
	require_once('config.inc.php');

	require_once('util4p/CRObject.class.php');
	require_once('util4p/CRErrorCode.class.php');
	require_once('util4p/MysqlPDO.class.php');
	require_once('util4p/SQLBuilder.class.php');

	require_once('init.inc.php');


	create_table_site();
	create_table_log();

	function execute_sqls($sqls)
	{
		foreach($sqls as $description=>$sql){
			echo "Executing $description: ";
			var_dump((new MysqlPDO)->execute($sql, array()));
		}
	}

	function create_table_site()
	{
		$sqls = array(
			'DROP `cr_site`' => 'DROP TABLE IF EXISTS `cr_site`',
			'CREATE `cr_site`' =>
			'CREATE TABLE `cr_site`( 
				`owner` varchar(12) not null,
				 index(`owner`),
				`site` varchar(256) not null,
				 index(`site`),
				`status` int not null default 0, /* 0-created, need verify, 2-verified */
				`add_time` int
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci',
		);
		execute_sqls($sqls);
	}

	function create_tables_option()
	{
		$sqls = array(
			'DROP `cr_option`' =>
			'DROP TABLE IF EXISTS `cr_option`',
			'CREATE `cr_option`' =>
			'CREATE TABLE `cr_option`(
				`key` varchar(64) primary key,
				`value` varchar(256),
				`remark` varchar(64)
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
		);
		execute_sqls($sqls);
	}

	function create_table_log()
	{
		$sqls = array(
			'DROP `cr_log`' => 'DROP TABLE IF EXISTS `cr_log`',
			'CREATE `cr_log`' =>
			'create table `cr_log`(
				`id` bigint AUTO_INCREMENT,
				 primary key(`id`),
				`tag` varchar(128) NOT NULL, 
				 index(`tag`),
				`level` int NOT NULL, /* too small value sets, no need to index */
				`time` bigint NOT NULL, 
				 index(`time`),
				`ip` bigint NOT NULL, /* situations when filter on ip is rare, no index */
				`content` text
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
		);
		execute_sqls($sqls);
	}
