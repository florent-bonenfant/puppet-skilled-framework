(function($) {


    // Helper: find closest scrolling parent
    // https://github.com/slindberg/jquery-scrollparent/blob/master/jquery.scrollparent.js
    if (!$.fn.scrollParent) {
        $.fn.scrollParent = function() {
            var overflowRegex = /(auto|scroll)/,
            position = this.css( "position" ),
            excludeStaticParent = position === "absolute",
            scrollParent = this.parents().filter( function() {
                var parent = $( this );
                if ( excludeStaticParent && parent.css( "position" ) === "static" ) {
                    return false;
                }
                var overflowState = parent.css(["overflow", "overflowX", "overflowY"]);
                return (overflowRegex).test( overflowState.overflow + overflowState.overflowX + overflowState.overflowY );
            }).eq( 0 );

            return position === "fixed" || !scrollParent.length ? $( this[ 0 ].ownerDocument || document ) : scrollParent;
        };
    }


    // Minimal template engine
    // NOTE: are allowed only direct values and one-level objects
    var tpl = function(html, data) {
        var match;
        while (match = /{{this\.((?:(?!}}).)+)}}/g.exec(html)) {
            html = html.replace(match[0], data[match[1]]);
        }
        return html.replace(/{{this}}/g, data);
    }


    // Autocomplete plugin
    $.fn.autocomplete = function(options) {
        this.each(function() {
            var that = $(this);
            if (!that.is('input')) {
                throw 'Autocomplete works on <input> elements only.';
            }

            // apply options
            var settings = $.extend({
                // General params
                template: '{{this}}',
                suggestions: [],
                defaultDisplayValue: '',
                alwaysSuggest: false,
                freeInput: true,
                invalidText: 'Invalid value',

                // AJAX params
                url: '',
                liveSuggest: false,

                // AJAX data callbacks
                // parameters to send as GET
                params: function() {
                    // NOTE `this` refers to the input element
                    return {
                        value: this.val()
                    };
                },
                // value to send as POST on submit
                result: function(item) {
                    return item;
                },
                // value to display in the input
                display: function(item) {
                    return item;
                },
                // on choose callback(data)
                onSelect: false, // NOTE `this` refers to the input element
                // on destroy callback(value)
                onDestroy: false, // NOTE `this` refers to the input element

                // texts
                emptyText: 'No result.',
                loadingText: 'Loading…',

                // classes
                wrapperClass: 'autocomplete-suggestions',
                suggestionClass: 'autocomplete-suggestion',
                focusClass: 'autocomplete-focus',
                emptyClass: 'autocomplete-empty',
                loadingClass: 'autocomplete-loading',
                invalidClass: 'autocomplete-invalid',
            }, options);

            // init result and display inputs
            var target = false;
            if (that.prop('name')) {
                target = $('<input type="hidden" name="' + that.prop('name') + '">')
                    .val(that.val())
                    .insertAfter(that);
                that.removeAttr('name');
            }
            that.prop('autocomplete', 'off')
                .val(settings.defaultDisplayValue);

            // set initial states
            var wrap = that.scrollParent();
            var setWrapBounds = function() {
                var bounds = wrap.offset();
                bounds.bottom = bounds.top + wrap.prop('scrollHeight');
                bounds.right = bounds.left + wrap.prop('scrollWidth');
                wrap.data('autocomplete-bounds', bounds);
            };
            setWrapBounds();
            var resizeTimeout = false;
            $(window).on('resize', function(e) {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(setWrapBounds, 100);
            });

            // bind events
            var list = $('<ul>').on('autocomplete-position', function() {
                    var ref = that.offset();
                    var css = {
                        top: ref.top + that.outerHeight(),
                        left: ref.left,
                        width: that.outerWidth(),
                        maxWidth: wrap.data('autocomplete-bounds').right - ref.left,
                    };

                    if (css.top + parseFloat(list.css('max-height')) > wrap.data('autocomplete-bounds').bottom - wrap.scrollTop()) {
                        css.top = 'auto';
                        css.bottom = $(window).height() - ref.top;
                    }
                    list.css(css);
                }).on('autocomplete-idle', function() {
                    list.empty()
                        .append('<li class="' + settings.loadingClass + '">' + settings.loadingText + '</li>')
                        .show();
                }).on('autocomplete-done', function() {
                    list.trigger('autocomplete-open');
                }).on('autocomplete-open', function() {
                    list.empty();
                    var items = list.children('li.' + settings.suggestionClass);
                    if (!list.data('autocomplete-suggestions').length) {
                        list.append('<li class="' + settings.emptyClass + '">' + settings.emptyText + '</li>');
                    } else if (settings.liveSuggest || items.length == 0) {
                        list.data('autocomplete-suggestions').forEach(function(item) {
                            $('<li class="' + settings.suggestionClass + '">' + tpl(settings.template, item) + '</li>')
                                .data('autocomplete-data', item)
                                .appendTo(list);
                        });
                    }
                    list.show()
                    items.children('li.' + settings.suggestionClass)
                        .first()
                        .addClass(settings.focusClass);
                }).on('autocomplete-close', function() {
                    list.hide();
                }).on('click', 'li.' + settings.suggestionClass, function() {
                    var self = $(this);
                    if (target) {
                        target.val(settings.result(self.data('autocomplete-data')));
                    }
                    that.val(settings.display(self.data('autocomplete-data')));
                    if (!settings.freeInput) {
                        that[0].setCustomValidity('');
                        that.removeClass(settings.invalidClass);
                    }
                    list.trigger('autocomplete-close');
                    if (settings.onSelect.call) {
                        settings.onSelect.call(self, self.data('autocomplete-data'));
                    }
                });

            // reposition on scroll
            wrap.on('scroll mousewheel touchmove', function() {
                requestAnimationFrame(function() {
                    list.trigger('autocomplete-position');
                });
            });

            // init list
            list.data('autocomplete-suggestions', settings.suggestions)
                .addClass(settings.wrapperClass)
                .css({
                    position: 'fixed',
                    overflow: 'auto',
                    maxHeight: list.css('max-height') || 200,
                    maxWidth: '100%',
                })
                .hide()
                .trigger('autocomplete-position')
                .insertAfter(that);

            // fetch suggestions
            var typeTimeout = false;
            that.data('autocomplete-last-value', that.val());
            that.on('keydown', function(e) {
                // keyboard navigation
                if (that.val() && [13, 27, 38, 40].indexOf(e.which) > -1) {
                    e.preventDefault();
                    var suggestions = list.children('li.' + settings.suggestionClass);
                    var current = suggestions.filter('.' + settings.focusClass).first();
                    current.removeClass(settings.focusClass);
                    if (e.which == 40) {
                        // DOWN: focus next
                        current = current.next();
                        if (!current.length) {
                            current = suggestions.first();
                        }
                    } else if (e.which == 38) {
                        // UP: focus prev
                        current = current.prev();
                        if (!current.length) {
                            current = suggestions.last();
                        }
                    } else if (e.which == 13) {
                        // ENTER: select value
                        current.trigger('click');
                    }
                    current.addClass(settings.focusClass);
                }
            }).on('focus keyup', function(e) {
                clearTimeout(typeTimeout);
                typeTimeout = setTimeout(function() {
                    // close list when empty
                    if (!that.val() && !settings.alwaysSuggest) {
                        list.trigger('autocomplete-close');
                        return true;
                    }

                    // skip if control key
                    if (e.type == 'keyup' && (e.which == 9 || (that.val() && [13, 38, 40].indexOf(e.which) > -1))) {
                        return true;
                    }
                    // skip if same value
                    if (e.type == 'keyup' && that.val() == that.data('autocomplete-last-value')) {
                        return true;
                    } else if (e.type == 'keyup') {
                        // empty real value until new one selected
                        target.val('');
                    }
                    that.data('autocomplete-last-value', that.val());

                    // display suggestions
                    if (!settings.liveSuggest && list.data('autocomplete-suggestions').length) {
                        // Static suggestions
                        list.trigger('autocomplete-open');
                    } else {
                        // Live suggestions or first load of static suggestions
                        list.trigger('autocomplete-idle');
                        var params = settings.params.call(that);
                        $.get(settings.url, params, function(result) {
                            list.data('autocomplete-suggestions', result.suggestions)
                                .trigger('autocomplete-done');
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR, textStatus, errorThrown);
                        });
                    }
                }, 100);
            }).on('blur', function() {
                setTimeout(function() {
                    list.trigger('autocomplete-close');
                }, 100);
            });


            // check value on sending form
            that.closest('form').on('submit', function(e) {
                if (!settings.freeInput && !target.val()) {
                    e.preventDefault();
                    that[0].setCustomValidity(settings.invalidText);
                    that.addClass(settings.invalidClass);
                    return false;
                } else if (!target.val()) {
                    target.val(that.val());
                }
            });

            // detroy
            that.on('autocomplete-destroy', function() {
                that.attr('name', target.prop('name')).val(target.val());
                target.remove();
                list.off().remove();
                that.off();
                if (settings.onDestroy.call) {
                    settings.onDestroy.call(that, that.val());
                }
            });
        });

        // return element
        return this;

    }; // end of Autocomplete plugin

})(jQuery);
