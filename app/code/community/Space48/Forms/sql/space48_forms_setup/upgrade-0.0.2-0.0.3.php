<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset');
$formTable = $this->getTable('space48_forms/form');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `fieldset_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
      `form_id` INT UNSIGNED NOT NULL,
      `name` VARCHAR(64) NOT NULL,
      `title` VARCHAR(128),
      `description` TEXT,
      `instructions` TEXT,
      `before_fields_content` TEXT,
      `after_fields_content` TEXT,
      `css_class` VARCHAR(128),
      `frontend_block` VARCHAR(240) DEFAULT 'space48_forms/form_fieldset',
      `frontend_template` VARCHAR(240) DEFAULT 'space48/forms/form/fieldset.phtml',
      `updated_at` DATETIME,
      `created_at` DATETIME,
      PRIMARY KEY (`fieldset_id`),
      CONSTRAINT `FK_SPACE48_FORMS_FIELDSET_TO_FORM` FOREIGN KEY (`form_id`) REFERENCES `{$formTable}`(`form_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    );
";

$this->run($sql);

$this->endSetup();
