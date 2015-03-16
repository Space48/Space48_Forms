<?php

class Space48_Troubleshoot_IndexController extends Space48_Troubleshoot_Controller_Abstract
{
    /**
     * index action
     *
     * @return void
     */
    public function indexAction()
    {
        // init variables
        $id     = $this->getRequest()->getParam('id');
        $issue  = Mage::getModel('space48_troubleshoot/issue');
        $issues = false;
        
        if ( $id ) {
            // load issue model
            $issue->load($id);
            
            // get children issues
            $issues = $issue->getChildren();
        } else {
            // get root issues
            $issues = Mage::getResourceModel('space48_troubleshoot/issue_collection');
            $issues->addRootFilter();
        }
        
        if ( $issues ) {
            $issues->addEnabledFilter();
        }
        
        // register variables
        Mage::register('current_issue', $issue);
        Mage::register('current_issues', $issues);
        
        $this->loadLayout();
        $this->renderLayout();
    }
}
