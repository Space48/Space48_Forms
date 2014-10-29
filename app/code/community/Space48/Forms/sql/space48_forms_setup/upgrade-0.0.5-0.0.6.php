<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form_fieldset_field_index');
$fieldsetTable = $this->getTable('space48_forms/form_fieldset');
$fieldTable = $this->getTable('space48_forms/form_fieldset_field');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(  
      `fieldset_id` INT UNSIGNED NOT NULL,
      `field_id` INT UNSIGNED NOT NULL,
      CONSTRAINT `FK_SPACE48_FORMS_INDEX_TO_FIELDSET` FOREIGN KEY (`fieldset_id`) REFERENCES `{$fieldsetTable}`(`fieldset_id`) ON UPDATE NO ACTION ON DELETE CASCADE,
      CONSTRAINT `FK_SPACE48_FORMS_INDEX_TO_FIELD` FOREIGN KEY (`field_id`) REFERENCES `{$fieldTable}`(`field_id`) ON UPDATE NO ACTION ON DELETE CASCADE
    );
";

$this->run($sql);

$this->endSetup();




