(function ($) {
    Drupal.behaviors.customize = {
        attach: function (context, settings) {
            // Your Javascript code goes here
            $('.block-uc-catalog .block-content > ul > li > span > a').addClass('disabled');

            $.each($('#block-system-main-menu .block-content > ul > li'), function(index, value) {
                //console.log(index + ':' + value);
                if($(value).find('ul').length) {
                    var a_element = $(value).find('a').first();
                    $(a_element).attr("href", "#")
                }
            });

        }
    };
}(jQuery));