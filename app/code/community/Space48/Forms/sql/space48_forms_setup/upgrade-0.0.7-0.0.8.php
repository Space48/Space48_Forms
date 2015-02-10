<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result_fieldset');
$resultTable = $this->getTable('space48_forms/form_result');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `result_fieldset_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `result_id` INT UNSIGNED NOT NULL,
      `name` VARCHAR(64) NOT NULL,
      `title` VARCHAR(128),
      `description` TEXT,
      `instructions` TEXT,
      `before_fields_content` TEXT,
      `after_fields_content` TEXT,
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`result_fieldset_id`),
      CONSTRAINT `FK_SPACE48_FORMS_RESULT_FIELDSET_TO_RESULT` FOREIGN KEY (`result_id`) REFERENCES `{$resultTable}`(`result_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
