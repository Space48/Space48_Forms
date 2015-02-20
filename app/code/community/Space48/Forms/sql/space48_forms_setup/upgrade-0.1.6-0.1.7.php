<?php

$this->startSetup();

$table       = $this->getTable('space48_forms/process_queue');
$formTable   = $this->getTable('space48_forms/form');
$resultTable = $this->getTable('space48_forms/form_result');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}` (
      `queue_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `form_id` INT UNSIGNED NOT NULL,
      `result_id` INT UNSIGNED NOT NULL,
      `status` VARCHAR(5) NOT NULL,
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`queue_id`),
      UNIQUE INDEX `S48_FORMS_UNIQUE_PROCESS_QUEUE` (`form_id`, `result_id`),
      CONSTRAINT `S48_FORMS_PROCESS_QUEUE_TO_FORM`   FOREIGN KEY (`form_id`)   REFERENCES `{$formTable}`(`form_id`)     ON UPDATE NO ACTION ON DELETE CASCADE,
      CONSTRAINT `S48_FORMS_PROCESS_QUEUE_TO_RESULT` FOREIGN KEY (`result_id`) REFERENCES `{$resultTable}`(`result_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    );
";

$this->run($sql);

$this->endSetup();
