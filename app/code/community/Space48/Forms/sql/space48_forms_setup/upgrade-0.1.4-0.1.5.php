<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result_fieldset_field');

$sql = "
    ALTER TABLE `{$table}`
      ADD COLUMN `validation` VARCHAR(32) NULL AFTER `required`,
      ADD COLUMN `validation_data` TEXT NULL AFTER `validation`;
";

$this->run($sql);

$this->endSetup();



