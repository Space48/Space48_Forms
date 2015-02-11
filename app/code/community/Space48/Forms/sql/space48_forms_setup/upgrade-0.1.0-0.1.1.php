<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result_fieldset_field');

$sql = "
    ALTER TABLE `{$table}`
      ADD COLUMN `file_extensions` TEXT NULL AFTER `type`,
      ADD COLUMN `file_size_limit` INT NULL AFTER `file_extensions`;
";

$this->run($sql);

$this->endSetup();




