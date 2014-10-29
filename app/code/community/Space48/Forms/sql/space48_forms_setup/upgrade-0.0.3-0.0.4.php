<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset_field');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(  
      `field_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(64) NOT NULL,
      `label` VARCHAR(64) NOT NULL,
      `title` VARCHAR(128),
      `type` VARCHAR(64) NOT NULL,
      `value` VARCHAR(128),
      `options` TEXT,
      `comment` TEXT,
      `hint` TEXT,
      `required` TINYINT NOT NULL DEFAULT 0,
      `css_style` TEXT,
      `css_class` VARCHAR(128),
      `container_class` VARCHAR(128),
      `autocapitalize` TINYINT NOT NULL DEFAULT 0,
      `autocorrect` TINYINT NOT NULL DEFAULT 0,
      `spellcheck` TINYINT NOT NULL DEFAULT 0,
      `autocomplete` TINYINT NOT NULL DEFAULT 0,
      `show_in_admin_email` TINYINT NOT NULL DEFAULT 1,
      `show_in_customer_email` TINYINT NOT NULL DEFAULT 1,
      `position` INT NOT NULL DEFAULT 0,
      `status` TINYINT NOT NULL DEFAULT 0,
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`field_id`)
    );
";

$this->run($sql);

$this->endSetup();
