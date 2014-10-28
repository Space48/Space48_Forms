<?php

$this->startSetup();

$table = $this->getTable('space48_forms/form');

$sql = "
    DROP TABLE IF EXISTS `{$table}`;
    CREATE TABLE `{$table}`(
      `form_id` INT UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Form ID.',
      `code` VARCHAR(32) NOT NULL COMMENT 'Form code, unique.',
      `title` VARCHAR(64) COMMENT 'Form title.',
      `description` TEXT COMMENT 'Form description.',
      `instructions` TEXT COMMENT 'Form instructions.',
      `success_content` TEXT COMMENT 'Success content.',
      `failure_content` TEXT COMMENT 'Failure content.',
      `before_form_content` TEXT COMMENT 'Before form content.',
      `after_form_content` TEXT COMMENT 'After form content.',
      `redirect_url` VARCHAR(240) COMMENT 'Redirect URL.',
      `submit_button_text` VARCHAR(128) COMMENT 'Submit button text.',
      `back_button_show` TINYINT DEFAULT 0 COMMENT 'Whether to show back button or not.',
      `back_button_text` VARCHAR(128) COMMENT 'Back button text.',
      `back_button_url` VARCHAR(240) COMMENT 'Back button URL.',
      `registered_only` TINYINT NOT NULL DEFAULT 0 COMMENT 'If only registered customers can fill and submit form.',
      `email_admin` TINYINT NOT NULL DEFAULT 0 COMMENT 'Whether to email the admin user.',
      `email_admin_address` VARCHAR(240) COMMENT 'Admin email address.',
      `email_admin_template` VARCHAR(240) COMMENT 'Admin email template.',
      `email_customer` TINYINT NOT NULL DEFAULT 0 COMMENT 'Whether to email customer.',
      `email_customer_template` VARCHAR(240) COMMENT 'Email template.',
      `email_customer_replyto` VARCHAR(240) COMMENT 'Reply to email address.',
      `email_customer_content` TEXT COMMENT 'Email content.',
      `email_customer_show_results` TINYINT NOT NULL DEFAULT 0 COMMENT 'Whether to show results or not.',
      `email_customer_before_results_content` TEXT COMMENT 'Content to show before the results.',
      `email_customer_after_results_content` TEXT COMMENT 'Content to show after the results.',
      `email_customer_footer_content` TEXT COMMENT 'Content to show in the footer.',
      `method` VARCHAR(4) DEFAULT 'POST'  COMMENT 'Form submit method.',
      `enctype` VARCHAR(32) NOT NULL DEFAULT 'multipart/form-data'  COMMENT 'Form enctype.',
      `css_class` VARCHAR(128) COMMENT 'Additional container CSS class.',
      `frontend_block` VARCHAR(240) NOT NULL DEFAULT 'space48_forms/form'  COMMENT 'The frontend block that renders the form.',
      `status` TINYINT NOT NULL DEFAULT 0 COMMENT 'Form status.',
      PRIMARY KEY (`form_id`),
      UNIQUE INDEX `UNIQUE_FORM_CODE` (`code`)
    ) ENGINE=INNODB;
";

$this->run($sql);

$this->endSetup();
