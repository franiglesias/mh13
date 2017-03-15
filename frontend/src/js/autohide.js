/* Manages show and hide of flash messages */

var flashMessage = $('.mh-flash');
Foundation.Motion.animateIn(flashMessage, "hinge-in-from-top");
setTimeout(function () {
    var autohide = $('.mh-autohide');
    Foundation.Motion.animateOut(autohide, "hinge-out-from-top");
}, 5000);

/**
 * Created by miralba on 15/3/17.
 */
