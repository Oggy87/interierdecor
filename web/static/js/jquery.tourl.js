
(function($){

    var nodiac = {'á': 'a', 'č': 'c', 'ď': 'd', 'é': 'e', 'ě': 'e', 'í': 'i', 'ň': 'n', 'ó': 'o', 'ř': 'r', 'š': 's', 'ť': 't', 'ú': 'u', 'ů': 'u', 'ý': 'y', 'ž': 'z'};

    var string = '';

    $.fn.tourl = function(options){

        var defaults = {
            divider : '-'
        };

	var options = $.extend(defaults, options);

        return this.each(function(){
            $(this).keyup(function(){
                var url = $(this).val();

                url = url.toLowerCase(); // change everything to lowercase
                url = nodiacritic(url);
                url = url
                .replace(/^\s+|\s+$/g, "") // trim leading and trailing spaces
                .replace(/[_|\s]+/g, "-") // change all spaces and underscores to a hyphen
                .replace(/[^a-z\u0400-\u04FF0-9-]+/g, "") // remove all non-cyrillic, non-numeric characters except the hyphen
                .replace(/[-]+/g, "-") // replace multiple instances of the hyphen with a single instance
                .replace(/^-+|-+$/g, "") // trim leading and trailing hyphens
                .replace(/[-]+/g, options.divider);

                $('#' + options.id).val(url);

            });
        });

        function nodiacritic(url) {
            var s2 = '';
            for (var i=0; i < url.length; i++) {
                s2 += (typeof nodiac[url.charAt(i)] != 'undefined' ? nodiac[url.charAt(i)] : url.charAt(i));
            }
            return s2;
                //return s2.replace(/[^a-z0-9_]+/g, '-').replace(/^-|-$/g, '');
        }
    }

})(jQuery);

