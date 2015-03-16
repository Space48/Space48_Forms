<?php

class Space48_Troubleshoot_Block_Issues extends Mage_Core_Block_Template
{
    /**
     * holds issue
     *
     * @var Space48_Troubleshoot_Model_Issue
     */
    protected $_issue;
    
    /**
     * holds form
     *
     * @var Space48_Forms_Model_Form
     */
    protected $_form;
    
    /**
     * holds issues
     *
     * @var Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    protected $_issues;
    
    /**
     * can show
     *
     * @return bool
     */
    public function canShow()
    {
        return true;
    }
    
    /**
     * construct
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
    }
    
    public function getBreadcrumbHtml()
    {
        $html = '';
        
        $parents = $this->getIssue()->getParents();
        
        foreach ( $parents as $parent ) {
            $html .= sprintf('
                <ul>
                    <li>
                        <a href="%s">
                            %s
                        </a>
            ', $this->getIssueUrl($parent), $parent->getTitle());
        }
        
        foreach ( $parents as $parent ) {
            $html .= '
                    </li>
                </ul>
            ';
        }
        
        return $html;
    }
    
    /**
     * get issue
     *
     * @return Space48_Troubleshoot_Model_Issue
     */
    public function getIssue()
    {
        if ( is_null($this->_issue) ) {
            $this->_issue = Mage::registry('current_issue');
        }
        
        return $this->_issue;
    }
    
    /**
     * set issue
     *
     * @param Space48_Troubleshoot_Model_Issue $issue
     */
    public function setIssue(Space48_Troubleshoot_Model_Issue $issue)
    {
        $this->_issue = $issue;
        
        return $this;
    }
    
    /**
     * has issue
     *
     * @return bool
     */
    public function hasIssue()
    {
        $issue = $this->getIssue();
        
        if ( ! $issue ) {
            return false;
        }
        
        if ( ! ( $issue instanceof Space48_Troubleshoot_Model_Issue ) ) {
            return false;
        }
        
        if ( ! $issue->getId() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get form
     *
     * @return Space48_Forms_Model_Form
     */
    public function getForm()
    {
        if ( is_null($this->_form) ) {
            $this->_form = $this->getIssue()->getForm();
        }
        
        return $this->_form;
    }
    
    /**
     * get form html
     *
     * @return string
     */
    public function getFormHtml()
    {
        // must have form
        if ( ! $this->hasForm() ) {
            return '';
        }
        
        // load block
        $block = $this->getLayout()->createBlock('space48_forms/form');
        
        // sanity check
        if ( ! ( $block instanceof Space48_Forms_Block_Form_Abstract ) ) {
            return '';
        }
        
        
        // set form to block
        $block->setForm( $this->getForm() );
        
        return $block->toHtml();
    }
    
    /**
     * has form
     *
     * @return bool
     */
    public function hasForm()
    {
        $form = $this->getForm();
        
        if ( ! $form ) {
            return false;
        }
        
        if ( ! ( $form instanceof Space48_Forms_Model_Form ) ) {
            return false;
        }
        
        if ( ! $form->getId() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get issues
     *
     * @return Space48_Troubleshoot_Model_Resource_Issue_Collection
     */
    public function getIssues()
    {
        if ( is_null($this->_issues) ) {
            $this->_issues = Mage::registry('current_issues');
        }
        
        return $this->_issues;
    }
    
    /**
     * set issues
     *
     * @param Space48_Troubleshoot_Model_Resource_Issue_Collection $issues
     */
    public function setIssues(Space48_Troubleshoot_Model_Resource_Issue_Collection $issues)
    {
        $this->_issues = $issues;
        
        return $this;
    }
    
    /**
     * has issues
     *
     * @return bool
     */
    public function hasIssues()
    {
        $issues = $this->getIssues();
        
        if ( ! $issues ) {
            return false;
        }
        
        if ( ! $issues->count() ) {
            return false;
        }
        
        return true;
    }
    
    /**
     * get issue url
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     *
     * @return string
     */
    public function getIssueUrl(Space48_Troubleshoot_Model_Issue $issue)
    {
        return $this->getUrl('troubleshoot/index/index', array(
            'id' => $issue->getId(),
        ));
    }
}
