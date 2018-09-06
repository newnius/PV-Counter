<?php

require_once('util4p/util.php');
require_once('util4p/MysqlPDO.class.php');

require_once('config.inc.php');
require_once('init.inc.php');


create_table_user();
create_table_site();
create_table_log();

function execute_sqls($sqls)
{
	foreach ($sqls as $description => $sql) {
		echo "Executing $description: ";
		var_dump((new MysqlPDO)->execute($sql, array()));
		echo "<hr/>";
	}
}

function create_table_user()
{
	$sqls = array(
		'DROP `ana_user`' =>
			'DROP TABLE IF EXISTS `ana_user`',
		'CREATE `ana_user`' =>
			'CREATE TABLE `ana_user`(
				`uid` int AUTO_INCREMENT,
				 PRIMARY KEY (`uid`),
				`open_id` varchar(64) NOT NULL,
				 UNIQUE (`open_id`),
				`email` varchar(64),
				`role` varchar(12) NOT NULL,
				`time` bigint
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
	);
	execute_sqls($sqls);
}

function create_table_site()
{
	$sqls = array(
		'DROP `ana_site`' => 'DROP TABLE IF EXISTS `ana_site`',
		'CREATE `ana_site`' =>
			'CREATE TABLE `ana_site`(
				`domain` VARCHAR(64) NOT NULL,
				 INDEX(`domain`), 
				`owner` int NOT NULL,
				 INDEX(`owner`),
				 UNIQUE(`owner`, `domain`),
				`verified` int NOT NULL DEFAULT 0
			)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci',
	);
	execute_sqls($sqls);
}

function create_table_log()
{
	$sqls = array(
		'DROP `ana_log`' => 'DROP TABLE IF EXISTS `ana_log`',
		'CREATE `ana_log`' =>
			'CREATE TABLE `ana_log`(
								`id` BIGINT AUTO_INCREMENT,
								 PRIMARY KEY(`id`),
								`scope` VARCHAR(128) NOT NULL,
								 INDEX(`scope`),
								`tag` VARCHAR(128) NOT NULL,
								 INDEX(`tag`),
								`level` INT NOT NULL, /* too small value sets, no need to index */
								`time` BIGINT NOT NULL,
								 INDEX(`time`), 
								`ip` BIGINT NOT NULL,
								 INDEX(`ip`),
								`content` json 
						)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci'
	);
	execute_sqls($sqls);
}
