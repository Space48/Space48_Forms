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
        
        // on ready
        $(function(){
            this.onReady();
        }.bind(this));
        
        // on load
        $(window).load(function(){
            this.onLoad();
        }.bind(this));
        
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
     * on ready
     * @return void
     */
    Space48Forms.Form_Abstract.prototype.onReady = function () {
        // scroll any errors into view
        this.scrollErrorsIntoView();
    };
    
    /**
     * on load
     * @return void
     */
    Space48Forms.Form_Abstract.prototype.onLoad = function () {};
    
    /**
     * scroll errors into view
     *
     * @return {this}
     */
    Space48Forms.Form_Abstract.prototype.scrollErrorsIntoView = function () {
        
        // get the first error field
        var errorField = this.$form.find('.has-errors').first();
        
        // if we have fields
        if ( errorField.length ) {
            errorField.velocity("scroll", { duration: 2000, easing: "easeOutQuint", offset: -100 });
        }
        
        return this;
    };
    
    
    /**
     * Space48 Form
     */
    Space48Forms.Form = Space48Forms.Form_Abstract.extend({});
}(jQuery));
