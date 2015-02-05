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

;(function($){
    /**
     * space48 forms namespace
     *
     * @type {Object}
     */
    this.Space48Forms = {};

    /**
     * Space48 Form Abstract
     */
    Space48Forms.Form_Abstract = Class.extend({
        
        /**
         * form id
         *
         * @type {string}
         */
        id  : null,
        
        /**
         * jquery object containing form
         *
         * @type {jQuery}
         */
        $form : null,
        
        /**
         * varien form
         *
         * @type {VarienForm}
         */
        varienForm : null,
        
        /**
         * config
         *
         * @type {Object}
         */
        config : {}
    });
    
    /**
     * constructor method
     *
     * @param  {string} id
     * @param  {object} config
     *
     * @return {this}
     */
    Space48Forms.Form_Abstract.prototype.init = function (id, config) {
        
        // id should be a truthy value
        if ( ! id ) {
            return this;
        }
        
        // set id
        this.id = id;
        
        // load jquery object with element id
        this.$form = $('#' + id);
        
        
        
        // don't continue if there is no elements found
        if ( this.$form.length == 0 ) {
            return this;
        }
        
        
        
        // extend config
        this.config = $.extend({}, this.config, config || {});
        
        // create varien form
        this.varienForm = new VarienForm(id);
        
        return this;
    };
    
    /**
     * get form
     *
     * @return {jQuery}
     */
    Space48Forms.Form_Abstract.prototype.getForm = function () {
        return this.$form;
    };
    
    /**
     * Space48 Form
     */
    Space48Forms.Form = Space48Forms.Form_Abstract.extend({});
}(jQuery));
