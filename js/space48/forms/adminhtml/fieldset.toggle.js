;(function(){
    /**
     * toggles visibility of fieldsets when
     * clicking the header title bar
     * 
     * usage:
     * 
     * var fieldsetToggle = new Space48Forms.FieldsetToggle();
     * 
     * or just:
     * 
     * (new Space48Forms.FieldsetToggle());
     */
    Space48Forms.FieldsetToggle = Class.extend({
        init : function () {
            var fieldsetHeaders = $$('.entry-edit-head');
            
            if ( ! fieldsetHeaders ) {
                return;
            }
            
            // for each fieldset header found
            fieldsetHeaders.each(function(fieldsetHeader){
                fieldsetHeader.observe('click', function(){
                    this.onHeaderClick(fieldsetHeader);
                }.bind(this));
            }.bind(this));
        },
        
        /**
         * on fieldset header click
         *
         * @return {this}
         */
        onHeaderClick : function (fieldsetHeader) {
            
            var fieldsetContent = fieldsetHeader.next();
            
            if ( fieldsetContent.visible() ) {
                fieldsetContent.hide();
            } else {
                fieldsetContent.show();
            }
            
            return this;
        }
    });
}());
