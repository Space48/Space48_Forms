<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset_field');

$sql = "
    ALTER TABLE `{$table}`
      ADD COLUMN `validation` VARCHAR(32) NULL AFTER `autocomplete`,
      ADD COLUMN `validation_data` TEXT NULL AFTER `validation`;
";

$this->run($sql);

$this->endSetup();



