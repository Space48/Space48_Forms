<?php

class Space48_Forms_Model_Observer_Result_Email
{
    /**
     * send result emails
     *
     * @param  Varien_Event_Observer $observer
     *
     * @return $this
     */
    public function sendResultEmails(Varien_Event_Observer $observer)
    {
        // only if module is enabled
        if ( ! Mage::helper('space48_forms')->isEnabled() ) {
            return $this;
        }
        
        /**
         * queue item
         *
         * @var Space48_Forms_Model_Process_Queue
         */
        $item = $observer->getEvent()->getItem();
        
        // check if we have a valid queue item
        if ( ! $this->_isValidQueueItem($item) ) {
            return $this;
        }
        
        // send customer email
        $this->_sendCustomerEmail($item);
        
        // send admin email
        $this->_sendAdminEmail($item);
        
        return $this;
    }
    
    /**
     * send customer email
     *
     * @param  Space48_Forms_Model_Process_Queue $item
     *
     * @return $this
     */
    protected function _sendCustomerEmail(Space48_Forms_Model_Process_Queue $item)
    {
        // get email model
        $email = Mage::getModel('space48_forms/email');
        
        // get email template
        $template = $item->getForm()->getEmailCustomerTemplate();
        
        // default to system default
        if ( ! $template ) {
            $template = Mage::helper('space48_forms')->getConfig('customer_notification_email_template');
        }
        
        // graceful exit
        if ( ! $template ) {
            return $this;
        }
        
        // get sender details
        $sender = $this->_getSenderDetails();
        
        // get "to" emails
        $emails = $this->_getCustomerRecipientDetails($item);
        
        // build subject
        $subject = Mage::helper('space48_forms')->__('%s - Submission Confirmation', $item->getForm()->getTitle());
        
        // prepare email
        $email->prepareEmail($subject, $template, $sender);
        
        // set reply to if we have it
        if ( $replyto = $item->getForm()->getEmailCustomerReplyto() ) {
            $email->setReplyTo($replyto);
        }
        
        // set cc addresses
        if ( $cc = $item->getForm()->getEmailCustomerAddressCc() ) {
            $cc = Mage::helper('space48_forms/form')->explode($cc, PHP_EOL);
            
            foreach ( $cc as $_cc ) {
                
                if ( ! $_cc ) {
                    continue;
                }
                
                // add cc
                $email->addCc($_cc);
            }
        }
        
        // set cc addresses
        if ( $bcc = $item->getForm()->getEmailCustomerAddressBcc() ) {
            $bcc = Mage::helper('space48_forms/form')->explode($bcc, PHP_EOL);
            
            foreach ( $bcc as $_bcc ) {
                
                if ( ! $_bcc ) {
                    continue;
                }
                
                // add cc
                $email->addBcc($_bcc);
            }
        }
        
        // send email
        $email->sendEmail($emails, array(
            'form'   => $item->getForm(),
            'result' => $item->getResult(),
        ));
        
        return $this;
    }
    
    /**
     * send admin email
     *
     * @param  Space48_Forms_Model_Process_Queue $item
     *
     * @return $this
     */
    protected function _sendAdminEmail(Space48_Forms_Model_Process_Queue $item)
    {
        // get email model
        $email = Mage::getModel('space48_forms/email');
        
        // get email template
        $template = $item->getForm()->getEmailAdminTemplate();
        
        // default to system default
        if ( ! $template ) {
            $template = Mage::helper('space48_forms')->getConfig('admin_notification_email_template');
        }
        
        // graceful exit
        if ( ! $template ) {
            return $this;
        }
        
        // get sender details
        $sender = $this->_getSenderDetails();
        
        // get "to" emails
        $emails = $this->_getAdminRecipientDetails($item);
        
        // build subject
        $subject = Mage::helper('space48_forms')->__('%s - Form Submission', $item->getForm()->getTitle());
        
        // prepare email
        $email->prepareEmail($subject, $template, $sender);
        
        // set cc addresses
        if ( $cc = $item->getForm()->getEmailAdminAddressCc() ) {
            $cc = Mage::helper('space48_forms/form')->explode($cc, PHP_EOL);
            
            foreach ( $cc as $_cc ) {
                
                if ( ! $_cc ) {
                    continue;
                }
                
                // add cc
                $email->addCc($_cc);
            }
        }
        
        // set cc addresses
        if ( $bcc = $item->getForm()->getEmailAdminAddressBcc() ) {
            $bcc = Mage::helper('space48_forms/form')->explode($bcc, PHP_EOL);
            
            foreach ( $bcc as $_bcc ) {
                
                if ( ! $_bcc ) {
                    continue;
                }
                
                // add cc
                $email->addBcc($_bcc);
            }
        }
        
        // send email
        $email->sendEmail($emails, array(
            'form'   => $item->getForm(),
            'result' => $item->getResult(),
        ));
        
        return $this;
    }
    
    /**
     * get admin recipient details
     *
     * @param  Space48_Forms_Model_Process_Queue $item
     *
     * @return array
     */
    protected function _getAdminRecipientDetails(Space48_Forms_Model_Process_Queue $item)
    {
        // get emails
        $emails = $item->getForm()->getEmailAdminAddressTo();
        
        // use default store email details if we do not have any emails
        // stored in the form
        if ( ! $emails ) {
            
            $name  = Mage::getStoreConfig('trans_email/ident_support/name');
            $email = Mage::getStoreConfig('trans_email/ident_support/email');
            
            return array($name => $email);
        }
        
        // explode emails
        $emails = Mage::helper('space48_forms/form')->explode($emails, PHP_EOL);
        
        // emails array to return
        $_emails = array();
        
        // build email array
        foreach ( $emails as $email ) {
            $name = substr($email, 0, strpos($email, '@'));
            
            $_emails[$name] = $email;
        }
        
        return $_emails;
    }
    
    /**
     * get customer recipient details
     *
     * @return array
     */
    protected function _getCustomerRecipientDetails(Space48_Forms_Model_Process_Queue $item)
    {
        // get name fields
        $nameFields = $item->getForm()->getEmailCustomerNameField();
        
        // get email field
        $emailField = $item->getForm()->getEmailCustomerAddressField();
        
        // must exist
        if ( ! $nameFields ) {
            $this->_exception('No name fields set for customer.');
        }
        
        if ( ! $emailField ) {
            $this->_exception('No email field set for customer.');
        }
        
        // convert to array
        $nameFields = Mage::helper('space48_forms/form')->explode($nameFields);
        
        // name array
        $name = array();
        
        // loop through names fields and build array
        foreach ( $nameFields as $field ) {
            // get field
            $field = $item->getResult()->getResultFields($field);
            
            // if we have field
            if ( $field ) {
                // if we have value
                if ( $value = $field->getValue() ) {
                    $name[] = trim($value);
                }
            }
        }
        
        // implode into name
        $name = trim(implode(' ', $name));
        
        // get email field
        $emailField = $item->getResult()->getResultFields($emailField);
        
        // initial email
        $email = '';
        
        // get email address
        if ( $emailField ) {
            $email = $emailField->getValue();
        }
        
        // if we dont have a valid name
        if ( ! $name ) {
            $this->_exception('Unable to locate name for customer.');
        }
        
        // if we do not have a valid email
        if ( ! $email ) {
            $this->_exception('Unable to locate email for customer.');
        }
        
        return array($name => $email);
    }
    
    /**
     * get sender details
     *
     * @return array
     */
    protected function _getSenderDetails()
    {
        return array(
            'name'  => Mage::getStoreConfig('trans_email/ident_support/name'),
            'email' => Mage::getStoreConfig('trans_email/ident_support/email'),
        );
    }
    
    /**
     * is valid queue item
     *
     * @param  Space48_Forms_Model_Process_Queue $item
     *
     * @return bool
     */
    protected function _isValidQueueItem($item)
    {
        // should be instance of...
        if ( ! ( $item instanceof Space48_Forms_Model_Process_Queue ) ) {
            return false;
        }
        
        // should be loaded
        if ( ! $item->getId() ) {
            return false;
        }
        
        // should have "fresh" status
        if ( $item->getStatus() != Space48_Forms_Model_Source_Process_Queue_Status::STATUS_FRESH ) {
            return false;
        }
        
        // should be able to load result model
        if ( ! $item->getResult()->getId() ) {
            return false;
        }
        
        // should be able to load form model
        if ( ! $item->getForm()->getId() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * throw exception
     *
     * @return void
     */
    protected function _exception()
    {
        $args = func_get_args();
        $message = call_user_func_array(array($this->_helper(), '__'), $args);
        Mage::throwException($message);
    }
    
    /**
     * get helper
     *
     * @param  string $helper
     *
     * @return Mage_Core_Helper_Abstract
     */
    protected function _helper($helper = 'space48_forms')
    {
        return Mage::helper($helper);
    }
}
