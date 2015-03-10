<?php

$this->startSetup();

$table = $this->getTable('space48_troubleshoot/issue');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `issue_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `parent_id` INT UNSIGNED NOT NULL,
      `form_id` INT UNSIGNED,
      `block_id` VARCHAR(240),
      `title` VARCHAR(240),
      `description` TEXT,
      `solution` TEXT,
      `status` TINYINT NOT NULL DEFAULT 0,
      `created_at` DATETIME,
      `updated_at` DATETIME,
      PRIMARY KEY (`issue_id`)
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
