"use strict";

/**
 * Created by miralba on 17/3/17.
 */
$(document).ready(function () {
    $(document).foundation();
});

$(document).ajaxComplete(function (event, xhr, settings) {
    $(document).foundation();
});