<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result_fieldset_field');
$fieldsetTable = $this->getTable('space48_forms/form_result_fieldset');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(  
      `result_field_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `fieldset_id` INT UNSIGNED,
      `name` VARCHAR(64) NOT NULL,
      `label` VARCHAR(64) NOT NULL,
      `title` VARCHAR(128),
      `type` VARCHAR(64) NOT NULL,
      `value` TEXT,
      `options` TEXT,
      `comment` TEXT,
      `hint` TEXT,
      `required` TINYINT NOT NULL DEFAULT 0,
      `show_in_admin_email` TINYINT NOT NULL DEFAULT 1,
      `show_in_customer_email` TINYINT NOT NULL DEFAULT 1,
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`result_field_id`),
      CONSTRAINT `FK_SPACE48_FORMS_RESULT_FIELD_TO_RESULT_FIELDSET` FOREIGN KEY (`fieldset_id`) REFERENCES `{$fieldsetTable}`(`result_fieldset_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
