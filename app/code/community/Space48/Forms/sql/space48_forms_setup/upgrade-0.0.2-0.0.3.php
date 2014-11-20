<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `fieldset_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `name` VARCHAR(64) NOT NULL,
      `title` VARCHAR(128),
      `description` TEXT,
      `instructions` TEXT,
      `before_fields_content` TEXT,
      `after_fields_content` TEXT,
      `css_class` VARCHAR(128),
      `frontend_block` VARCHAR(240) DEFAULT 'space48_forms/form_fieldset',
      `frontend_template` VARCHAR(240) DEFAULT 'space48/forms/form/fieldset.phtml',
      `status` TINYINT DEFAULT 0,
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`fieldset_id`)
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
