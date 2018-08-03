'use strict';

/**
 * Created by miralba on 4/5/17.
 */
function parse_link_header(header) {
    var parts = header.split(',');
    var links = {};
    for (i = 0; i < parts.length; i++) {
        var section = parts[i].split(';');
        var url = section[0].replace(/<(.)>/, '$1').trim();
        var name = section[1].replace(/rel="(.)"/, '$1').trim();
        links[name] = url;
    }
    return links;
}