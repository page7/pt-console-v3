/*!
 * jquery highlight plugin
 * https://github.com/page7/highlight
 *
 * MIT license.
 *
 * Version:0.0.1
 * Date:2018-08
 */

;(function ($) {

    $.fn.highlight = function(options) {
        return this.each(function(){
            var item = $(this);

            if (!item.data("_highlightOpts"))
                item.data("_highlightOpts", $.fn.highlight.defaults);

            var opts = $.extend({}, $.fn.highlight.defaults, item.data("_highlightOpts"), options),
                replace = function(node, options, keyword){
                    if (!keyword) return;

                    var skip = 0;

                    if (node.nodeType == 3) {
                        if ( (pos = node.data.search(keyword)) >= 0 ) {
                            var match   = node.data.slice(pos).match(keyword)[0],
                                _node   = document.createElement(options.tag),
                                _tmp    = node.splitText(pos),
                                _end    = _tmp.splitText(match.length),
                                _clone  = _tmp.cloneNode(true);

                            _node.className = options.classname;

                            _node.appendChild(_clone);
                            node.parentNode.replaceChild(_node, _tmp);
                            skip = 1;
                        }
                    }
                    else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName) && (!options.filter || $(node).is(options.filter))) {
                        for (var i = 0; i < node.childNodes.length; ++i) {
                            i += replace(node.childNodes[i], options, keyword);
                        }
                    }

                    return skip;
                };

            item.data("_highlightOpts", opts);

            $(this).off("search.highlight").on("search.highlight", {options: opts}, function(event, keyword){
                replace(this, event.data.options, keyword);
            });

            $(this).off("clear.highlight").on("clear.highlight", {options: opts}, function(event, keyword){
                var opts = event.data.options;
                $(this).find(opts.tag + "." + opts.classname).each(function() {
                    var parent = this.parentNode;
                    parent.replaceChild(this.firstChild, this);
                    parent.normalize();
                });
            });
        });

    }

    $.fn.highlight.defaults = {
        tag: "mark",
        classname: "highlight",
        filter: ""
    };

})(jQuery);

