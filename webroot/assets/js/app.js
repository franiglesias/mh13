var MHCounter = 0;

// toggleClick allows to bind several functions to a click event so you can trigger every one on every click
$.fn.toggleClick = function () {
    var functions = arguments,
        iteration = 0
    return this.click(function () {
        functions[iteration].apply(this, arguments)
        iteration = (iteration + 1) % functions.length
    })
}

$.fn.scrollToMe = function (speed, callFunc) {
    var that = this;
    setTimeout(function () {
        var targetOffset = that.offset()
            .top - 10;
        $('html,body')
            .eq(0)
            .animate({
                scrollTop: targetOffset
            }, speed || 500, callFunc);
    }, 500);
    return this;
};

// Returns a two digit number right padded with 0
function pad(n) {
    return n < 10 ? '0' + n : n;
}


function showMessage(message, type) {
    $('#mh-messages')
        .append(
            $('<div/>')
            .attr('data-alert', true)
            .addClass("mh-flash " + type)
            .text(message)
            .hide()
            .slideToggle('slow')
            .delay(3000)
            .slideToggle('slow')
        );
}
$(document)
    .ready(function () {

        $(document)
            .foundation();
        $(document)
            .trigger('mh-refresh');
    });

$(document)
    .ajaxComplete(function (event, xhr, settings) {
        $(document)
            .foundation();
        $(document)
            .trigger('mh-refresh');
    });

$(document)
    .off('mh-refresh')
    .on('mh-refresh', function () {



        // Here starts
        //;// Autocomplete fields. Autocomplete view should return an array of label, value keys
        $('.mh-autocomplete')
            .autocomplete({
                minLength: 3,
                source: function (request, response) {
                    var selector = '#' + this.element[0].id;
                    var url = $(selector)
                        .attr('mh-url');
                    $.ajax({
                        dataType: "json",
                        global: false,
                        url: url,
                        data: {
                            term: request.term
                        },
                        success: function (data) {
                            response($.map(data, function (item) {
                                return {
                                    label: item.label,
                                    value: item.value
                                };
                            }));
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            alert(textStatus);
                            alert(errorThrown);
                        }
                    });
                },
                // updates fields with current menu selection
                focus: function (event, ui) {
                    var selector = '#' + event.target.id;
                    var target = '#' + $(selector)
                        .attr('mh-target');
                    $(selector)
                        .val(ui.item.label);
                    $(target)
                        .val(ui.item.value);
                    return false
                },
                // fix the desired value and label
                select: function (event, ui) {
                    var selector = '#' + event.target.id;
                    var target = '#' + $(selector)
                        .attr('mh-target');
                    $(selector)
                        .val(ui.item.label);
                    $(target)
                        .val(ui.item.value);
                    return false;
                },
            });
        // End autocomplete
        ; // Ajax button

        $('.mh-ajax-button')
            .off('click')
            .on('click',
                function (event) {
                    var MHIndicator = $(this)
                        .attr('mh-indicator');
                    var MHUpdate = $(this)
                        .attr('mh-update');
                    $(MHIndicator)
                        .fadeIn();
                    $.ajax({
                        url: $(this)
                            .attr('href'),
                        cache: false,
                        success: function (data) {
                            $(MHUpdate)
                                .html(data);
                        },
                        complete: function (data) {
                            $(MHIndicator)
                                .fadeOut();
                        }
                    });
                    return false;
                });; // Ajax Button Update

        $(".mh-ajax-btn-update")
            .off('click')
            .on("click", function (event) {
                $.ajax({
                    dataType: "html",
                    evalScripts: true,
                    url: $(this)
                        .attr('href'),
                    beforeSend: function (XMLHttpRequest) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn()
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                    },
                });
                return false;
            });; // Checkboxes selector with select/deselect all button
        $('.mh-check-all')
            .toggleClick(function () {
                var selector = $(this)
                    .attr('mh-target');
                $('[id^=' + selector + ']')
                    .prop('checked', true);
                $(this)
                    .val($(this)
                        .attr('mh-message-uncheck'));
            }, function () {
                var selector = $(this)
                    .attr('mh-target');
                $('[id^=' + selector + ']')
                    .prop('checked', false);
                $(this)
                    .val($(this)
                        .attr('mh-message-check'));
            });
        // End Check All

        // Clear fields with a clear button
        $('.mh-clearfield')
            .click(function (index) {
                var selector = $(this)
                    .attr('mh-target');
                $(selector)
                    .val('');
                var altSelector = selector + '-alt';
                if (altSelector != undefined) {
                    $(altSelector)
                        .val('');
                };
            });
        // End Clear fields


        // Dates selector support
        var d = new Date();
        var fd = pad(d.getDate()) + '-' + pad(d.getMonth() + 1) + '-' + d.getFullYear();

        $('.mh-date')
            .datepicker({
                dateFormat: "dd-mm-yy",
                showOtherMonths: true,
                selectOtherMonths: true,
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: 'focus',
                altField: 'alt',
                altFormat: 'yy-mm-dd'
            });

        $('.mh-date')
            .datepicker($.datepicker.regional['es']);

        $('.mh-date')
            .each(function () {
                $(this)
                    .datepicker('option', 'altField', $(this)
                        .attr('mh-altfield'));
                $(this)
                    .datepicker('option', 'altFormat', 'yy-mm-dd');
            })

        if ($.fn.multiDatesPicker) {
            $('.mh-multidate')
                .multiDatesPicker({
                    dateFormat: "dd-mm-yy",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    showOn: "focus",
                    // addDates: fd,
                    altField: '#alt',
                    altFormat: 'yy-mm-dd'
                });
            $(".mh-multidate")
                .multiDatesPicker($.datepicker.regional['es']);
            $('#ui-datepicker-div')
                .css('clip', 'auto');

            $('.mh-multidate')
                .each(function () {
                    $(this)
                        .datepicker('option', 'altField', $(this)
                            .attr('mh-altfield'));
                    $(this)
                        .datepicker('option', 'altFormat', 'yy-mm-dd');
                });

            $('.mh-date-range')
                .multiDatesPicker({
                    dateFormat: "dd-mm-yy",
                    showOtherMonths: true,
                    selectOtherMonths: true,
                    changeMonth: true,
                    changeYear: true,
                    showButtonPanel: true,
                    showOn: "focus",
                    // addDates: fd,
                    altField: '#alt',
                    altFormat: 'yy-mm-dd',
                    maxPicks: 2,
                });
            $(".mh-date-range")
                .multiDatesPicker($.datepicker.regional['es']);
            $('.mh-date-range')
                .each(function () {
                    $(this)
                        .datepicker('option', 'altField', $(this)
                            .attr('mh-altfield'));
                    $(this)
                        .datepicker('option', 'altFormat', 'yy-mm-dd');
                });
        };
        // End Dates selector support

        // Associate permissions in contents module
        $('.mh-bind')
            .off('click')
            .on('click',
                function (event) {
                    $('#mh-permissions-busy-indicator')
                        .fadeIn();
                    var update = $(this)
                        .attr('mh-update');
                    $.ajax({
                        data: {
                            owm: $(this)
                                .attr('mh-owner-model'),
                            owid: $($(this)
                                    .attr('mh-owner-id'))
                                .val(),
                            obm: $(this)
                                .attr('mh-object-model'),
                            obid: $(this)
                                .attr('mh-object-id'),
                            access: $($(this)
                                    .attr('mh-access'))
                                .val(),
                            cburl: $(this)
                                .attr('mh-url')
                        },
                        url: owVars.Url.bind,
                        success: function (data) {
                            $(update)
                                .html(data);
                        },
                        complete: function (data) {
                            $('#mh-permissions-busy-indicator')
                                .fadeOut();
                        }
                    });
                    return false;
                });

        $('.mh-unbind')
            .off('click')
            .on('click',
                function (event) {
                    $('#mh-permissions-busy-indicator')
                        .fadeIn();
                    var update = $(this)
                        .attr('mh-update');
                    $.ajax({
                        data: {
                            owm: $(this)
                                .attr('mh-owner-model'),
                            owid: $(this)
                                .attr('mh-owner-id'),
                            obm: $(this)
                                .attr('mh-object-model'),
                            obid: $(this)
                                .attr('mh-object-id'),
                            cburl: $(this)
                                .attr('mh-url')
                        },
                        url: owVars.Url.unbind,
                        success: function (data) {
                            $(update)
                                .html(data);
                        },
                        complete: function (data) {
                            $('#mh-permissions-busy-indicator')
                                .fadeOut();
                        }

                    });
                    return false;
                });

        $('.mh-rebind')
            .off('change')
            .on('change',
                function (event) {
                    $('#mh-permissions-busy-indicator')
                        .fadeIn();
                    var update = $(this)
                        .attr('mh-update');
                    $.ajax({
                        data: {
                            owm: $(this)
                                .attr('mh-owner-model'),
                            owid: $(this)
                                .attr('mh-owner-id'),
                            obm: $(this)
                                .attr('mh-object-model'),
                            obid: $(this)
                                .attr('mh-object-id'),
                            access: $(this)
                                .val(),
                            cburl: $(this)
                                .attr('mh-url')
                        },
                        url: owVars.Url.rebind,
                        success: function (data) {
                            $(update)
                                .html(data);
                        },
                        complete: function (data) {
                            $('#mh-permissions-busy-indicator')
                                .fadeOut();
                        }
                    });
                    return false;
                });
        // End permissions


        // Show/hide a div and change writeability of a field
        $('.mh-disclose')
            .toggleClick(function () {
                event.preventDefault();
                var selector = $(this)
                    .attr('mh-target');
                $(selector)
                    .show();
                var roField = $(this)
                    .attr('mh-readonly-field');
                $('input[id^=' + roField + ']')
                    .prop('readonly', true);
            }, function () {
                event.preventDefault();
                var selector = $(this)
                    .attr('mh-target');
                $(selector)
                    .hide();
                var roField = $(this)
                    .attr('mh-readonly-field');
                $('input[id^=' + roField + ']')
                    .prop('readonly', false);
            });
        // End diclose

        // Show/hide elements based on select change values
        $('.mh-show-by-value')
            .on('change', function (event) {
                var currentValue = $(this)
                    .val();
                var showOnEmpty = $(this)
                    .attr('mh-show-on-empty');
                var showOnValue = $(this)
                    .attr('mh-show-on-value');
                if (currentValue == false) {
                    $(showOnValue)
                        .hide();
                    $(showOnEmpty)
                        .show();
                } else {
                    $(showOnEmpty)
                        .hide();
                    $(showOnValue)
                        .show();
                };
            });

        $(window)
            .on('load', function (event) {
                $('.mh-show-by-value')
                    .trigger('change');
            });

        // End show/hide elements based on select change values

        // Translate button for forms
        $('.mh-translate')
            .click(function (event) {
                event.stopPropagation();
                event.preventDefault();
                var sfield = '#' + $(this)
                    .attr('sfield');
                var tfield = '#' + $(this)
                    .attr('tfield');
                $(tfield + '-busy')
                    .fadeIn();
                $.get(
                    jsVars.translate, {
                        text: $(sfield)
                            .val(),
                        sl: $(this)
                            .attr('sl'),
                        tl: $(this)
                            .attr('tl')
                    },
                    function (data, textStatus, xhr) {
                        $(tfield)
                            .val(data);
                        $(tfield + '-busy')
                            .fadeOut();
                    });
            });
        // End translate button

        // Show / hide notifications
        setTimeout(function () {
            $(".mh-flash")
                .fadeOut("slow", function () {
                    $(this)
                        .remove();
                });
        }, 6000);
        $(".mh-flash")
            .fadeIn("slow");
        // End Show / Hide notifications

        // File Uploaders
        if (typeof qq !== 'undefined') {

            function uploaderRefresh(upl, aFile, aPath) {
                theUpdate = upl._element.id;
                if (upl._options.mhMode == 'inline') {
                    var theRefresh = upl._options.mhRefresh + '/' + aFile;
                    $('#' + upl._options.mhField)
                        .val(aPath);
                } else {
                    var theRefresh = upl._options.mhRefresh;
                };
                previewUpdate(upl, theRefresh, theUpdate, false);
            }

            function firstTimeInlinePreview(upl) {
                theField = upl._options.mhField;
                theFile = basename($('#' + theField)
                    .val());
                theUpdate = upl._element.id;
                theRefresh = upl._options.mhRefresh + '/' + theFile;
                previewUpdate(upl, theRefresh, theUpdate, true)
            }

            function hidePreview(preview) {
                $('#' + preview)
                    .find('.qq-upload-preview-list')
                    .hide("slide", {
                        direction: "left"
                    }, 1000)
            }

            function showPreview(preview) {
                $('#' + preview)
                    .find('.qq-upload-preview-list')
                    .show("slide", {
                        direction: "up"
                    }, 1000)
            }


            function previewUpdate(upl, theRefresh, theUpdate, async) {
                theBusy = jsVars['assets'] + "ajax-loader.gif";
                $('#' + theUpdate)
                    .find('.qq-upload-preview-list')
                    .fadeIn();
                $('#' + theUpdate)
                    .find('.qq-upload-preview-list')
                    .html('<img scr="' + theBusy + '" />');
                $.ajax({
                    url: theRefresh,
                    global: false,
                    async: async,
                    data: {
                        class: upl._options.mhClass,
                        fk: upl._options.mhFk,
                        field: upl._options.mhModelField
                    },

                    success: function (data) {
                        $('#' + theUpdate)
                            .find('.qq-upload-preview-list')
                            .hide();
                        $('#' + theUpdate)
                            .find('.qq-upload-preview-list')
                            .html(data);
                        showPreview(theUpdate);
                    }
                });
            }

            function basename(path) {
                return path.split('/')
                    .reverse()[0];
            }

            $('.uploader')
                .on('click', '.mh-uploader-cleaner', function (event) {
                    $('#' + $(this)
                            .attr('mh_target'))
                        .val('');
                    $(this)
                        .parent()
                        .parent()
                        .find('.qq-upload-preview-list')
                        .html('');
                });

            var uploaders = new Array();

            //alert('File Uploader Loaded');

            $('.uploader')
                .each(function (index) {
                    var Uploader = new qq.FileUploader({
                        debug: false,
                        element: $(this)[0],
                        action: $(this)
                            .attr('mh-upload'),
                        multiple: $(this)
                            .attr('mh-multiple') == '1' ? true : false,
                        allowedExtensions: jsVars['extensions'][$(this)
                            .attr('mh-extensions')],
                        sizeLimit: 0,
                        mhMode: $(this)
                            .attr('mh-mode'),
                        mhRefresh: $(this)
                            .attr('mh-refresh'),
                        mhDiv: $(this)
                            .attr('id'),
                        mhClass: $(this)
                            .attr('mh-class'),
                        mhFk: $(this)
                            .attr('mh-fk'),
                        mhModelField: $(this)
                            .attr('mh-field'),
                        mhField: $(this)
                            .attr('mh-target'),
                        mhCompleteUrl: $(this)
                            .attr('mh-complete-url'),
                        mhCompleteUpdate: $(this)
                            .attr('mh-complete-update'),
                        uploadButtonText: 'Haz clic para seleccionar archivos.',
                        dragText: 'Arrastra archivos aquí.',
                        hideShowDropArea: true,
                        template: '<div class="qq-uploader">' +
                            '<div class="qq-upload-manage small-3 columns">' +
                            '<div class="qq-upload-drop-area"><span>{dragText}</span></div>' +
                            '<div class="qq-upload-button">{uploadButtonText}</div>' +
                            '</div>' +
                            '<div class="qq-upload-preview-list"></div>' +
                            '<div class="qq-upload-progress-info small-9 columns"><ul class="qq-upload-list"></ul></div>' +
                            '</div>',
                        fileTemplate: '<li>' +
                            '<span class="qq-progress-bar"></span>' +
                            '<span class="qq-upload-file"></span>' +
                            '<span class="qq-upload-spinner"></span>' +
                            '<span class="qq-upload-size"></span>' +
                            '<a class="qq-upload-cancel" href="#">{cancelButtonText}</a>' +
                            '<span class="qq-upload-failed-text">{failUploadtext}</span>' +
                            '</li>',

                        params: {
                            class: $(this)
                                .attr('mh-class'),
                            plugin: $(this)
                                .attr('mh-plugin'),
                            field: $(this)
                                .attr('mh-field'),
                            fk: $(this)
                                .attr('mh-fk'),
                            limit: $(this)
                                .attr('mh-limit'),
                            extensions: jsVars['extensions'][$(this)
                                .attr('mh-extensions')].toString()
                        },
                        onComplete: function (id, fileName, responseJSON) {
                            if (Uploader._options.mhMode == 'inline') {
                                uploaderRefresh(Uploader, responseJSON.file, responseJSON.path);
                            };
                            if (Uploader._options.mhCompleteUrl != undefined) {
                                $.get(Uploader._options.mhCompleteUrl, function (data, textStatus, xhr) {
                                    $(Uploader._options.mhCompleteUpdate)
                                        .html(data);
                                });
                            };
                            var item = Uploader._getItemByFileId(id);
                            $(item)
                                .fadeOut(1600, "linear");
                        },
                        onProgress: function (id, fileName, loaded, total) {
                            var item = Uploader._getItemByFileId(id);
                            var size = Uploader._find(item, 'size');
                            hidePreview(Uploader._element.id);
                            size.style.display = 'inline';
                            var text;
                            var percent = Math.round(loaded / total * 100);
                            if (loaded != total) {
                                // If still uploading, display percentage
                                text = percent + '% de ' + Uploader._formatSize(total);
                            } else {
                                // If complete, just display final size
                                text = Uploader._formatSize(total);
                            }
                            // Update progress bar <span> tag
                            Uploader._find(item, 'progressBar')
                                .style.width = percent + '%';
                            qq.setText(size, text);
                        },

                    });



                    if (Uploader._options.mhMode == 'inline') {
                        var btn = $('<button/>', {
                            text: 'Borrar',
                            id: 'Clear-' + Uploader._options.mhField,
                            type: 'button',
                            mh_target: Uploader._options.mhField,
                            class: 'mh-uploader-cleaner mh-webkit-reset mh-button mh-button-delete mh-btn-uploader-clear',
                            click: 'return false;'
                        });
                        $(this)
                            .find('.qq-upload-manage')
                            .append(btn);
                        firstTimeInlinePreview(Uploader);
                    } else {
                        hidePreview(Uploader._element.id);
                        // uploaderRefresh(Uploader);
                    };
                    uploaders.push(Uploader);
                });
        };
        // End File uploaders

        // Ajax edition buttons
        // Ajax Add

        $('.mh-ajax-add')
            .off('click')
            .on('click', function (event) {
                $.ajax({
                    async: true,
                    dataType: 'html',
                    evalScripts: true,
                    url: $(this)
                        .attr('mh-url'),
                    beforeSend: function (XMLHttpRequest) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn();
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .foundation('reveal', 'open');
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                    },
                });
                return false;
            });

        // Ajax submit button for ajax edit forms
        $(".mh-ajax-send")
            .off('click')
            .on("click", function (event) {
                $.ajax({
                    data: $(this)
                        .closest("form")
                        .serialize(),
                    dataType: "html",
                    evalScripts: true,
                    type: "post",
                    url: $(this)
                        .attr('mh-url'),
                    beforeSend: function (XMLHttpRequest) {
                        $($(event.target)
                                .attr('mh-close'))
                            .foundation('reveal', 'close');
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn();
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                    },
                });
                return false;
            });

        // Edit button for tables

        $(".mh-ajax-btn-reveal")
            .off('click')
            .on("click", function (event) {
                $.ajax({
                    dataType: "html",
                    evalScripts: true,
                    url: $(this)
                        .attr('href'),
                    beforeSend: function (XMLHttpRequest) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn()
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .foundation('reveal', 'open');
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                    },
                });
                return false;
            });






        // When a reveal is closed try to repopulate the "parent" form
        $(document)
            .off('close.fndtn.reveal')
            .on('close.fndtn.reveal', '[data-reveal]', function () {
                var modal = $(this);
                var MHUrl = $(this)
                    .attr('mh-url');
                if (MHUrl == undefined) {
                    return false;
                };
                $.getJSON(MHUrl, function (data) {
                    $.each(data, function (fieldId, content) {
                        $('#' + fieldId)
                            .val(content);
                    });
                    console.log("Form updated");
                    return false;
                });
                return false;
            });


        // Dependant selects

        $(".mh-parent-select")
            .on("change", function (event) {
                $.ajax({
                    async: true,
                    global: false,
                    data: {
                        key: $(this)
                            .val()
                    },
                    dataType: "html",
                    url: $(this)
                        .attr('mh-url'),
                    beforeSend: function (xhr, textStatus) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn();
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                    },
                });
                return false;
            });; // Image Rotate

        $(".mh-image-rotate")
            .off('click')
            .on("click", function (event) {
                event.preventDefault();
                event.stopPropagation();
                var params = {};
                params.file = $(event.target)
                    .attr('mh-file');
                params.angle = $(event.target)
                    .attr('mh-angle');
                params.size = $(event.target)
                    .attr('mh-size');

                $.ajax({
                    async: true,
                    dataType: "html",
                    url: $(this)
                        .attr('href'),
                    data: params,
                    global: false,
                    beforeSend: function (XMLHttpRequest) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeIn();
                    },
                    success: function (data, textStatus) {
                        $($(event.target)
                                .attr('mh-update'))
                            .html(data);
                    },
                    complete: function (XMLHttpRequest, textStatus) {
                        $($(event.target)
                                .attr('mh-indicator'))
                            .fadeOut();
                        showMessage('Image rotated', 'mh-success');
                    },
                });
                return false;
            });;
    });
