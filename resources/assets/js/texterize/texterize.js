var Texterize = function($input, settings) {

    //Helper variables
    var input = $input[0];
    var self = this;

    //Local Variables
    var slots = [];

    //Setup the texterize variable
    input.texterize = self;

    $.extend(settings, {
        name: $input.data('name')
    });

    //var computedStyle = window.getComputedStyle && window.getComputedStyle(input, null);

    //Extend default state
    $.extend(self, {
        settings         : settings,
        $input           : $input
    });

    //Constructor methods
    self.setup();
};

// methods
// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

$.extend(Texterize.prototype, {

    /**
     * Create and setup elements
     */
    setup: function(){
        var self = this;
        var settings = this.settings;
        var $commitInput;

        //Init jquery elements
        self.$input.addClass('texterized');
        self.$input.attr('contenteditable',true);

        $commitInput = $('<input type="hidden">').attr('data-name', settings.name);
        $commitInput.appendTo(self.$input);

        //Promote local variables
        self.$commitInput = $commitInput;

        //Setup listeners
        self.$input.on('change keydown keypress input', function(){
            var bDisplayPlaceholder = self.$input.text().length > 0;

            if(bDisplayPlaceholder)
                self.$input.attr('data-div-placeholder-content',true);
            else
                self.$input.removeAttr('data-div-placeholder-content');
        });
    }
});

Texterize.defaults = {};

// JQuery Section
$.fn.texterize = function(userSettings) {

    var settings = $.extend({}, Texterize.defaults, userSettings);

    return this.each(function() {
        if (this.texterize) return;

        var instance;
        var $input = $(this);
        var tag_name = this.tagName.toLowerCase();
        var placeholder = $input.attr('placeholder') || $input.attr('data-placeholder');
        if (!placeholder && !settings.allowEmptyOption) {
            placeholder = $input.children('option[value=""]').text();
        }

        var settings_element = {
            'placeholder' : placeholder
        };

        instance = new Texterize($input, $.extend(true, {}, Texterize.defaults, settings_element, userSettings));
    });
};