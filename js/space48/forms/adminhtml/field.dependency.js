;(function(){
    /**
     * this allows us to specify fields
     * that are dependent on other field
     * and that should not show up unless
     * a certain field has a value
     * 
     * usage:
     * 
     * new Space48Forms.FieldDependency([field_id], [the_value_it_should_be], [array_of_field_ids_to_toggle]);
     * 
     * example:
     * 
     * new Space48Forms.FieldDependency('has_shipping_address', '1', [
     *     'street_1',
     *     'street_2',
     *     'city',
     *     'region',
     *     'postcode'
     * ]);
     */
    Space48Forms.FieldDependency = Class.extend({
        
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
            
            // fire initially
            this.onFieldChange();
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
                var value = this.getValue();
                var given = this.getField().getValue().toString();
                
                // is array
                if ( value instanceof Array ) {
                    show = value.indexOf(given) !== -1;
                }
                
                // assume string
                else {
                    show = value == given;
                }
            }
            
            // loop through dependant fields
            this.getFields().each(function(field){
                // ensure we have a non null value
                if ( field ) {
                    
                    var tr = field.up('tr');
                    
                    // show or hide the field
                    if ( show ) {
                        tr.show();
                        toggleInputElements(tr, true);
                    } else {
                        tr.hide();
                        toggleInputElements(tr, false);
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
            this.value = value;
            return this;
        },
        
        /**
         * get value
         *
         * @return {string}
         */
        getValue : function () {
            return this.value;
        },
        
        /**
         * empty function
         *
         * @return {void}
         */
        noop : function () {}
    });
}());
