<?php

class Space48_Troubleshoot_Block_Admin_Issue_Tree extends Mage_Adminhtml_Block_Template
{
    /**
     * holds html id
     *
     * @var string
     */
    protected $_htmlId;
    
    /**
     * holds nodes
     *
     * @var array
     */
    protected $_nodes;
    
    /**
     * constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('space48/troubleshoot/issue/tree.phtml');
    }
    
    /**
     * get html id
     *
     * @return string
     */
    public function getHtmlId()
    {
        if ( is_null($this->_htmlId) ) {
            $this->_htmlId = uniqid();
        }
        
        return $this->_htmlId;
    }
    
    /**
     * get nodes
     *
     * @return array
     */
    public function getIssueNodes()
    {
        if ( is_null($this->_nodes) ) {
            $this->_nodes = $this->_getIssueNodes();
        }
        
        return $this->_nodes;
    }
    
    /**
     * get nodes
     *
     * @param  int $parent
     *
     * @return array
     */
    protected function _getIssueNodes($parent = 0)
    {
        $nodes = array();
        
        // get issues collection
        $issues = Mage::getResourceModel('space48_troubleshoot/issue_collection');
        $issues->addParentFilter($parent);
        $issues->setOrder('sort', 'ASC');
        
        foreach ( $issues as $issue ) {
            $node = array(
                /**
                 * general data
                 */
                'id'       => 'node_' . $issue->getId(),
                'text'     => $issue->getTitle(),
                'children' => array(),
                
                /**
                 * a_attr
                 */
                'a_attr' => array(
                    'style' => $this->getIssueStyles($issue),
                ),
                
                /**
                 * data
                 */
                'data' => array(
                    'id'        => $issue->getId(),
                    'url'       => $this->getIssueUrl($issue),
                    'parent_id' => $issue->getParentId(),
                ),
            );
            
            if ( $issue->hasChildren() ) {
                $node['children'] = $this->_getIssueNodes($issue->getId());
            }
            
            $nodes[] = $node;
        }
        
        return $nodes;
    }
    
    /**
     * get selected node json
     *
     * @return string
     */
    public function getSelectedNodesJson()
    {
        if ( $id = $this->getSelectedId() ) {
            return '[\'node_' . $id . '\']';
        }
        
        return '[]';
    }
    
    /**
     * get should be selected id
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     *
     * @return int
     */
    protected function getSelectedId()
    {
        if ( $id = $this->_getModel()->getId() ) {
            return $id;
        }
        
        if ( $id = $this->getRequest()->getParam('parent_id') ) {
            return $id;
        }
        
        return false;
    }
    
    /**
     * get model
     *
     * @return Space48_Troubleshoot_Model_Issue
     */
    protected function _getModel()
    {
        return Mage::registry('current_issue');
    }
    
    /**
     * get add root issue url
     *
     * @return string
     */
    public function getAddRootIssueUrl()
    {
        return $this->getUrl('*/*/index', array(
            'parent_id' => 0,
        ));
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
        return $this->getUrl('*/*/index', array(
            'id' => $issue->getId(),
        ));
    }
    
    /**
     * get issue style
     *
     * @param  Space48_Troubleshoot_Model_Issue $issue
     *
     * @return string
     */
    public function getIssueStyles(Space48_Troubleshoot_Model_Issue $issue)
    {
        $styles = array();
        
        if ( ! $issue->getStatus() ) {
            $styles[] = 'color:#888;';
            $styles[] = 'text-decoration: line-through;';
        }
        
        return implode(' ', $styles);
    }
    
    /**
     * get update node positions url
     *
     * @return string
     */
    public function getUpdateNodePositionsUrl()
    {
        return $this->getUrl('*/*/updateNodePositions', array(
            '_query' => array(
                'isAjax' => 'true',
            ),
        ));
    }
    
    /**
     * get config
     *
     * @return array
     */
    public function getConfig()
    {
        return array(
            /**
             * core
             */
            'core' => array(
                'data'           => $this->getIssueNodes(),
                'multiple'       => false,
                'animation'      => false,
                'check_callback' => true,
            ),
            
            /**
             * state
             */
            'state' => array(
                'key' => 'issue_nodes',
            ),
            
            /**
             * drag and drop
             */
            'dnd' => array(
                'copy'       => false,
                'inside_pos' => 'last',
            ),
            
            /**
             * context menu
             */
            'contextmenu' => array(
                'items' => array(),
            ),
            
            /**
             * plugins
             */
            'plugins' => array(
                'state',
                'dnd',
                'contextmenu',
                'wholerow',
            ),
        );
    }
    
    /**
     * get context menu items
     *
     * @return array
     */
    public function getContextMenuItems()
    {
        /**
         * add child method
         */
        $addchild = sprintf('
            function (data) {
                var node = tree.get_node(data.reference);
                
                setLocation("%sparent_id/" + node.data.id);
            }
        ', $this->getUrl('*/*/index'));
        
        /**
         * delete method
         */
        $delete = sprintf('
            function (data) {
                var node = tree.get_node(data.reference);
                
                setLocation("%sid/" + node.data.id);
            }
        ', $this->getUrl('*/*/delete'));
        
        /**
         * build and return array
         */
        return array(
            'addchild' => array(
                'label'  => $this->__('Add Child'),
                'action' => new Zend_Json_Expr($addchild),
            ),
            'delete' => array(
                'label'  => $this->__('Delete'),
                'action' => new Zend_Json_Expr($delete),
            ),
        );
    }
    
    /**
     * get context menu items json
     *
     * @return string
     */
    public function getContextMenuItemsJson()
    {
        return Zend_Json::encode($this->getContextMenuItems(), false, array(
            'enableJsonExprFinder' => true,
        ));
    }
    
    /**
     * get json config
     *
     * @return string
     */
    public function getJsonConfig()
    {
        return Zend_Json::encode($this->getConfig(), false, array(
            'enableJsonExprFinder' => true,
        ));
    }
}
