<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result_fieldset_field');

$sql = "
    ALTER TABLE `{$table}`
      ADD COLUMN `errors` TEXT NULL AFTER `show_in_customer_email`;
";

$this->run($sql);

$this->endSetup();
