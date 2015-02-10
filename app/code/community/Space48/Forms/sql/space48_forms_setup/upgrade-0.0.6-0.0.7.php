<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_result');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `result_id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Result form ID.',
      `form_id` INT UNSIGNED COMMENT 'Form ID.',
      `title` VARCHAR(64) COMMENT 'Form title.',
      `description` TEXT COMMENT 'Form description.',
      `instructions` TEXT COMMENT 'Form instructions.',
      `before_form_content` TEXT COMMENT 'Before form content.',
      `after_form_content` TEXT COMMENT 'After form content.',
      `registered_only` TINYINT NOT NULL DEFAULT 0 COMMENT 'If only registered customers can fill and submit form.',
      `customer_id` INT UNSIGNED COMMENT 'Store customer ID of submission.',
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`result_id`)
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
