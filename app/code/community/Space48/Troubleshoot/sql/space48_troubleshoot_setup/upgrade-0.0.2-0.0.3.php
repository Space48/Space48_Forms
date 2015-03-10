<?php

$this->startSetup();

$table = $this->getTable('space48_troubleshoot/issue');

$sql = "
    ALTER TABLE `{$table}`   
      ADD COLUMN `sort` INT DEFAULT 0  NOT NULL AFTER `status`;
";

$this->run($sql);

$this->endSetup();
