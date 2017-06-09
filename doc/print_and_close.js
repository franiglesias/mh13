/**
 * Created by miralba on 9/6/17.
 */
// http://www.violato.net/blog/javascript/115-close-browser-window-after-print
// Print&Close code by Dicky Leonardo

function PrintWindow() {
    window.print();
    CheckWindowState();
}

function CheckWindowState() {
    if (document.readyState == "complete") {
        window.close();
    } else {
        setTimeout("CheckWindowState()", 2000)
    }
}
PrintWindow();

