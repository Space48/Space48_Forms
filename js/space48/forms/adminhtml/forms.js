;(function(){
    
    /**
     * this quick function allows us to pass in a parent
     * element and it will loop through all grids within
     * it and find their respective input and select elements
     * and disable them
     * 
     * the reason behind this is because when a grid exists
     * within a form all its input/select elements are
     * recognised by the form and posted alongside all the
     * usual data. this poses a problem when you have elements
     * within the grid which have the same name as input/select
     * elements within the form - you will either have blank
     * data passed where there should be data or you'll just
     * have the wrong data passed.
     * 
     * so when this plugin disables all the inputs within
     * every grid under the given parent elements no data
     * from them is then recognised or posted through.
     * 
     */
    this.toggleAllGridInputElements = function (parent, toggle) {
        
        // find all grid elements
        var grids = parent.select('div.grid');
        
        // only continue if we match elements
        if ( ! grids || ! grids.length ) {
            return;
        }
        
        // loop through all grids
        grids.each(function(grid){
            toggleInputElements(grid, toggle);
        });
    };
    
    /**
     * toggle input elements on/off
     */
    this.toggleInputElements = function (parent, toggle) {
        // find all input and select elements
        var elements = parent.select('input', 'select', 'textarea');
        
        // ensure we have matched elements
        if ( elements && elements.length ) {
            
            // loop through elements...
            elements.each(function(element){
                
                // ...and enable or disable
                if ( !! toggle ) {
                    element.enable();
                } else {
                    element.disable();
                }
            });
        }
    };
    
    /**
     * Abstract form
     */
    var Form_Abstract = Class.extend({
        /**
         * constructor
         *
         * @param  {varienForm} form
         *
         * @return {void}
         */
        init : function (form) {
            
            if ( ! form ) {
                return;
            }
            
            // set form
            this.setVarienForm(form);
            
            // init fieldsets
            new Space48Forms.FieldsetToggle();
            
            // init event handlers
            this.initEventHandlers();
        },
        
        /**
         * init event handlers
         *
         * @return {this}
         */
        initEventHandlers : function () {
            
            // ensure we have the global events object
            if ( typeof varienGlobalEvents === 'undefined' ) {
                return this;
            }
            
            varienGlobalEvents.attachEventHandler('showTab', function(arg) {
                this.setActiveTab(arg.tab.name);
            }.bind(this));
            
            /**
             * this listens to an event fired when the ajax validation
             * of the form is completed. we take the argument given
             * and check if there was an error.
             * 
             * if there was an error we need to ensure that all the
             * elements within the grid(s) that we disable before
             * submitting the form are enabled again to restore
             * standard grid functionality
             */
            varienGlobalEvents.attachEventHandler('formValidateAjaxComplete', function(arg) {
                if ( arg.responseText.evalJSON().error ) {
                    toggleAllGridInputElements(this.getVarienFormElement(), 1);
                }
            }.bind(this));
            
            return this;
        },
        
        /**
         * get active tab field element
         *
         * @return {Element}
         */
        getActiveTabFieldElement : function () {
            if ( typeof this.activeTabFieldElement === 'undefined' ) {
                // create hidden field
                var field = new Element('input', {
                    'type'  : 'hidden',
                    'name'  : 'active_tab',
                    'value' : '',
                });
                
                // insert into form
                this.getVarienFormElement().insert(field);
                
                // cache
                this.activeTabFieldElement = field;
            }
            
            return this.activeTabFieldElement
        },
        
        /**
         * set active tab
         *
         * @param {string} tab
         */
        setActiveTab : function (tab) {
            this.getActiveTabFieldElement().setValue(tab);
        },
        
        /**
         * get varien form
         *
         * @return {varienForm}
         */
        getVarienForm : function () {
            return this.varienForm;
        },
        
        /**
         * get varien form
         *
         * @param {varienForm} form
         */
        setVarienForm : function (form) {
            this.varienForm = form;
            return this;
        },
        
        /**
         * get varien form element
         *
         * @return {Element}
         */
        getVarienFormElement : function () {
            if ( ( typeof this.varienFormElement ) === 'undefined' ) {
                this.varienFormElement = $(this.getVarienForm().formId);
            }
            
            return this.varienFormElement;
        },
        
        /**
         * on before save
         * this must return true for the save to continue
         *
         * @return {boolean}
         */
        beforeSave : function () {
            // need to disable all grid input elements
            toggleAllGridInputElements(this.getVarienFormElement(), 0);
            
            return true;
        },
        
        /**
         * save action
         *
         * @param  {bool} andContinue
         *
         * @return {this}
         */
        save : function (andContinue) {
            
            if ( this.beforeSave() !== true ) {
                return this;
            }
            
            var url = '';
            
            if ( andContinue ) {
                if ( this.getVarienFormElement() ) {
                    url = this.getVarienFormElement().action + 'back/edit/';
                }
            }
            
            this.getVarienForm().submit(url);
            
            return this;
        },
        
        /**
         * save and continue action
         *
         * @return {this}
         */
        saveAndContinue : function () {
            return this.save(true);
        },
        
        /**
         * empty function
         *
         * @return {void}
         */
        noop : function () {}
    });
    
    /**
     * Form form
     */
    var Form_Form = Form_Abstract.extend({
        init : function (form) {
            this._super(form);
            
            // admin emails
            new Space48Forms.FieldDependency('email_admin', '1', [
                'email_admin_address_to',
                'email_admin_address_cc',
                'email_admin_address_bcc',
                'email_admin_template'
            ]);
            
            // customer emails
            new Space48Forms.FieldDependency('email_customer', '1', [
                'email_customer_address_cc',
                'email_customer_address_bcc',
                'email_customer_replyto',
                'email_customer_template',
                'email_customer_content',
                'email_customer_show_results',
                'email_customer_footer_content'
            ]);
            
            // customer email show results
            new Space48Forms.FieldDependency('email_customer_show_results', '1', [
                'email_customer_before_results_content',
                'email_customer_after_results_content'
            ]);
            
            // back button fields
            new Space48Forms.FieldDependency('back_button_show', '1', [
                'back_button_text',
                'back_button_url'
            ]);
        }
    });
    
    /**
     * Fieldset form
     */
    var Form_Fieldset = Form_Abstract.extend({});
    
    /**
     * Field form
     */
    var Form_Field = Form_Abstract.extend({
        init : function (form) {
            this._super(form);
            
            // default value
            new Space48Forms.FieldDependency('type', ['text', 'select', 'radio', 'textarea'], [
                'value'
            ]);
            
            // placeholder
            new Space48Forms.FieldDependency('type', ['text'], [
                'placeholder'
            ]);
            
            // options
            new Space48Forms.FieldDependency('type', ['select', 'radio', 'checkbox', 'multiselect', 'multicheckbox'], [
                'options'
            ]);
            
            // file extensions, file size limit
            new Space48Forms.FieldDependency('type', ['file'], [
                'file_extensions',
                'file_size_limit'
            ]);
            
        }
    });
    
    // expose to global namespace
    Space48Forms.Form_Form     = Form_Form;
    Space48Forms.Form_Fieldset = Form_Fieldset;
    Space48Forms.Form_Field    = Form_Field;
}());
