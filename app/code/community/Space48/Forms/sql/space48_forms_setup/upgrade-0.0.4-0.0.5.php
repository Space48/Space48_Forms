<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset_index');
$formTable = $this->getTable('space48_forms/form');
$fieldsetTable = $this->getTable('space48_forms/form_fieldset');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(  
      `form_id` INT UNSIGNED NOT NULL,
      `fieldset_id` INT UNSIGNED NOT NULL,
      CONSTRAINT `FK_SPACE48_FORMS_INDEX_TO_FORM` FOREIGN KEY (`form_id`) REFERENCES `{$formTable}`(`form_id`) ON UPDATE NO ACTION ON DELETE CASCADE,
      CONSTRAINT `FK_SPACE48_FORMS_INDEX_TO_FIELDSET` FOREIGN KEY (`fieldset_id`) REFERENCES `{$fieldsetTable}`(`fieldset_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    );
";

$this->run($sql);

$this->endSetup();




