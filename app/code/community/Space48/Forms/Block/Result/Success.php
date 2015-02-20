<?php

class Space48_Forms_Block_Result_Success extends Space48_Forms_Block_Result_Abstract
{
    /**
     * get success content
     *
     * @return string
     */
    public function getSuccessContent()
    {
        // try get success content from form
        $content = $this->getForm()->getSuccessContent();
        
        // if we have the content then return it
        if ( $content ) {
            return $content;
        }
        
        // if we do not get any content then try load
        // from a static block
        return $this->getLayout()->createBlock('cms/block')->setBlockId('space48_forms_default_success_content')->toHtml();
    }
}
