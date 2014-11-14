;(function(){
    
    /**
     * Simple JavaScript Inheritance
     * 
     * @see http://ejohn.org/blog/simple-javascript-inheritance/
     */
    ;(function(){var d=!1,g=/xyz/.test(function(){xyz})?/\b_super\b/:/.*/;
    this.Class=function(){};Class.extend=function(b){function c(){!d&&
    this.init&&this.init.apply(this,arguments)}var e=this.prototype;d=!0;
    var f=new this;d=!1;for(var a in b)f[a]="function"==typeof b[a]&&
    "function"==typeof e[a]&&g.test(b[a])?function(a,b){return function()
    {var c=this._super;this._super=e[a];var d=b.apply(this,arguments);
    this._super=c;return d}}(a,b[a]):b[a];c.prototype=f;
    c.prototype.constructor=c;c.extend=arguments.callee; return c}})();
    
    /**
     * toggles visibility of fieldsets when
     * clicking the header title bar
     * 
     * usage:
     * 
     * var fieldsetToggle = new FieldsetToggle();
     * 
     * or just:
     * 
     * (new FieldsetToggle());
     */
    var FieldsetToggle = Class.extend({
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
    
    /**
     * this allows us to specify fields
     * that are dependent on other field
     * and that should not show up unless
     * a certain field has a value
     * 
     * usage:
     * 
     * new FieldDependency([field_id], [the_value_it_should_be], [array_of_field_ids_to_toggle]);
     * 
     * example:
     * 
     * new FieldDependency('has_shipping_address', '1', [
     *     'street_1',
     *     'street_2',
     *     'city',
     *     'region',
     *     'postcode'
     * ]);
     */
    var FieldDependency = Class.extend({
        
        /**
         * constructor
         *
         * @param  {string} field
         * @param  {string|int} value
         * @param  {array} fields
         *
         * @return {void}
         */
        init : function (field, value, fields) {
            this.setField(field);
            this.setValue(value);
            this.setFields(fields);
            
            this.getField().observe('change', function(){
                this.onFieldChange();
            }.bind(this));
        },
        
        /**
         * on field change
         *
         * @return {this}
         */
        onFieldChange : function (toggle) {
            
            // default value for show
            var show = false;
            
            // if toggle === false then 
            // we have to ensure that we
            // hide this as it is a sub
            // dependency
            if ( toggle === false )  {
                show = false;
            }
            
            // otherwise we rely always
            // on the value of the field
            else {
                show = this.getField().getValue().toString() == this.getValue();
            }
            
            // loop through dependant fields
            this.getFields().each(function(field){
                // ensure we have a non null value
                if ( field ) {
                    // show or hide the field
                    if ( show ) {
                        field.up('tr').show();
                    } else {
                        field.up('tr').hide();
                    }
                    
                    // if we have sub dependencies
                    if ( field.__dependency ) {
                        field.__dependency.onFieldChange(show);
                    }
                }
            });
            
            return this;
        },
        
        /**
         * set field
         *
         * @param {string} field
         */
        setField : function (field) {
            this.field = $(field);
            
            // set variable to allow
            // application to recognise
            // that this field has
            // dependencies
            this.field.__dependency = this;
            
            return this;
        },
        
        /**
         * get field
         *
         * @return {Element}
         */
        getField : function () {
            return this.field;
        },
        
        /**
         * set fields
         *
         * @param {array} fields
         */
        setFields : function (fields) {
            
            var _fields = [];
            
            fields.each(function(field){
                _fields.push( $(field) );
            });
            
            this.fields = _fields;
            
            return this;
        },
        
        /**
         * get fields
         *
         * @return {array}
         */
        getFields : function () {
            return this.fields
        },
        
        /**
         * set value
         *
         * @param {string|int} value
         */
        setValue : function (value) {
            this.value = value.toString();
            return this;
        },
        
        /**
         * get value
         *
         * @return {string}
         */
        getValue : function () {
            return this.value.toString();
        },
        
        /**
         * empty function
         *
         * @return {void}
         */
        noop : function () {}
    });
    
    /**
     * Abstract form
     */
    var Forms_Abstract = Class.extend({
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
            new FieldsetToggle();
            
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
         * save action
         *
         * @param  {bool} andContinue
         *
         * @return {this}
         */
        save : function (andContinue) {
            
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
    var Forms_Form = Forms_Abstract.extend({
        init : function (form) {
            this._super(form);
            
            // admin emails
            new FieldDependency('email_admin', '1', [
                'email_admin_address_to',
                'email_admin_address_cc',
                'email_admin_address_bcc',
                'email_admin_template'
            ]);
            
            // customer emails
            new FieldDependency('email_customer', '1', [
                'email_customer_address_cc',
                'email_customer_address_bcc',
                'email_customer_replyto',
                'email_customer_template',
                'email_customer_content',
                'email_customer_show_results',
                'email_customer_footer_content'
            ]);
            
            // customer email show results
            new FieldDependency('email_customer_show_results', '1', [
                'email_customer_before_results_content',
                'email_customer_after_results_content'
            ]);
            
            // back button fields
            new FieldDependency('back_button_show', '1', [
                'back_button_text',
                'back_button_url'
            ]);
        }
    });
    
    /**
     * Fieldset form
     */
    var Forms_Fieldset = Forms_Abstract.extend({});
    
    /**
     * Field form
     */
    var Forms_Field = Forms_Abstract.extend({});
    
    // expose to global namespace
    window.Space48_Forms_Form     = Forms_Form;
    window.Space48_Forms_Fieldset = Forms_Fieldset;
    window.Space48_Forms_Field    = Forms_Field;
}());
