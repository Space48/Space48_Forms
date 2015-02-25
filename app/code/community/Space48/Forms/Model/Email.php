<?php

class Space48_Forms_Model_Email extends Mage_Core_Model_Email_Template
{
    /**
     * prepare to send email
     *
     * @param  string $subject
     * @param  string $template
     * @param  array  $sender
     *
     * @return $this
     */
    public function prepareEmail($subject, $template, array $sender)
    {
        // get store id
        $storeId = $this->getDesignConfig()->getStore();
        
        // if template is numeric
        if ( is_numeric($template) ) {
            $this->load($template);
        }
        
        // else is string
        else {
            $localeCode = Mage::getStoreConfig('general/locale/code', $storeId);
            $this->loadDefault($template, $localeCode);
        }
        
        // must be loaded now
        if ( ! $this->getId() ) {
            throw Mage::exception('Mage_Core', Mage::helper('space48_forms')->__('Invalid transactional email code: %s', $template));
        }
        
        // set sender details
        $this->setSenderName($sender['name']);
        $this->setSenderEmail($sender['email']);
        
        // set subject
        $this->setTemplateSubject($subject);
        
        return $this;
    }
    
    /**
     * set reply to
     *
     * @param string $email
     * @param string $name
     */
    public function setReplyTo($email, $name = '')
    {
        $this->getMail()->setReplyTo($email, $name);
        return $this;
    }
    
    /**
     * add cc
     *
     * @param string $email
     * @param string $name
     */
    public function addCc($email, $name = '')
    {
        $this->getMail()->addCc($email, $name);
        return $this;
    }
    
    /**
     * add bcc
     *
     * @param string $email
     */
    public function addBcc($email)
    {
        $this->getMail()->addBcc($email);
        return $this;
    }
    
    /**
     * send email
     *
     * @param  array $emails
     * @param  array $variables
     *
     * @return $this
     */
    public function sendEmail(array $emails, array $variables = array())
    {
        // split names/emails
        $emails = array_values($emails);
        $names  = array_keys($emails);
        
        // assign name/email to variables
        $variables['email'] = reset($emails);
        $variables['name'] = reset($names);
        
        // ini set
        ini_set('SMTP', Mage::getStoreConfig('system/smtp/host'));
        ini_set('smtp_port', Mage::getStoreConfig('system/smtp/port'));
        
        // get mail
        $mail = $this->getMail();
        
        // add emails
        foreach ($emails as $key => $email) {
            $mail->addTo($email, '=?utf-8?B?' . base64_encode($names[$key]) . '?=');
        }
        
        // use absolute links
        $this->setUseAbsoluteLinks(true);
        
        // get text
        $text = $this->getProcessedTemplate($variables, true);
        
        // is text email
        if ( $this->isPlain() ) {
            $mail->setBodyText($text);
        }
        
        // is html email
        else {
            $mail->setBodyHTML($text);
        }
        
        // set subject
        $mail->setSubject('=?utf-8?B?' . base64_encode($this->getProcessedTemplateSubject($variables)) . '?=');
        
        // set from
        $mail->setFrom($this->getSenderEmail(), $this->getSenderName());
        
        // send
        $mail->send();
        
        // reset to null
        $this->_mail = null;
        
        return $this;
    }
}
