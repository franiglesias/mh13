/*!
 * http://jqueryte.com
 * jQuery TE 1.3.2
 * Copyright (C) 2012, Fatih Koca (fatihkoca@me.com), AUTHOR.txt (http://jqueryte.com/about)
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 You should have received a copy of the GNU General Public ºLicense along with this library; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */
(function (e) {
    e.fn.jqte = function (t) {
        function f(e, t, n, r, i) {
            var s = a.length + 1;
            return a.push({name: e, cls: s, command: t, key: n, tag: r, emphasis: i})
        }

        var n = [{title: "Font Size"}, {title: "Color"}, {title: "Bold", hotkey: "B"}, {
            title: "Italic",
            hotkey: "I"
        }, {title: "Underline", hotkey: "U"}, {title: "Ordered List", hotkey: "."}, {
            title: "Unordered List",
            hotkey: ","
        }, {title: "Subscript", hotkey: "down arrow"}, {title: "Superscript", hotkey: "up arrow"}, {
            title: "Outdent",
            hotkey: "left arrow"
        }, {
            title: "Indent",
            hotkey: "right arrow"
        }, {title: "Justify Left"}, {title: "Justify Center"}, {title: "Justify Right"}, {
            title: "Strike Through",
            hotkey: "K"
        }, {title: "Add Link", hotkey: "L"}, {title: "Remove Link"}, {
            title: "Cleaner Style",
            hotkey: "Delete"
        }, {title: "Horizontal Rule", hotkey: "H"}, {title: "Source"}];
        var r = ["10", "12", "16", "18", "20", "24", "28"];
        var i = ["0,0,0", "68,68,68", "102,102,102", "153,153,153", "204,204,204", "238,238,238", "243,243,243", "255,255,255", "244,204,204", "252,229,205", "255,242,204", "217,234,211", "208,224,227", "207,226,243", "217,210,233", "234,209,220", "234,153,153", "249,203,156", "255,229,153", "182,215,168", "162,196,201", "159,197,232", "180,167,214", "213,166,189", "224,102,102", "246,178,107", "255,217,102", "147,196,125", "118,165,175", "111,168,220", "142,124,195", "194,123,160", "255,0,0", "255,153,0", "255,255,0", "0,255,0", "0,255,255", "0,0,255", "153,0,255", "255,0,255", "204,0,0", "230,145,56", "241,194,50", "106,168,79", "69,129,142", "61,133,198", "103,78,167", "166,77,121", "153,0,0", "180,95,6", "191,144,0", "56,118,29", "19,79,92", "11,83,148", "53,28,117", "116,27,71", "102,0,0", "120,63,4", "127,96,0", "39,78,19", "12,52,61", "7,55,99", "32,18,77", "76,17,48"];
        var s = ["Web Address", "E-mail Address", "Picture URL"];
        var o = e.extend({
            css: "jqte",
            title: true,
            titletext: n,
            button: "OK",
            fsize: true,
            fsizes: r,
            funit: "px",
            color: true,
            linktypes: s,
            b: true,
            i: true,
            u: true,
            ol: true,
            ul: true,
            sub: true,
            sup: true,
            outdent: true,
            indent: true,
            left: true,
            center: true,
            right: true,
            strike: true,
            link: true,
            unlink: true,
            remove: true,
            rule: true,
            source: true
        }, t);
        var u = navigator.userAgent.toLowerCase();
        if (/msie [1-7]./.test(u)) o.title = false;
        var a = [];
        f("fsize", "fSize", "", "", false);
        f("color", "colors", "", "", false);
        f("b", "Bold", "B", ["b", "strong"], true);
        f("i", "Italic", "I", ["i", "em"], true);
        f("u", "Underline", "U", ["u"], true);
        f("ol", "insertorderedlist", "¾", ["ol"], true);
        f("ul", "insertunorderedlist", "¼", ["ul"], true);
        f("sub", "subscript", "(", ["sub"], true);
        f("sup", "superscript", "&", ["sup"], true);
        f("outdent", "outdent", "%", ["blockquote"], false);
        f("indent", "indent", "'", ["blockquote"], true);
        f("left", "justifyLeft", "", "", false);
        f("center", "justifyCenter", "", "", false);
        f("right", "justifyRight", "", "", false);
        f("strike", "strikeThrough", "K", ["strike"], true);
        f("link", "linkcreator", "L", ["a"], true);
        f("unlink", "unlink", "", ["a"], false);
        f("remove", "removeformat", ".", "", false);
        f("rule", "inserthorizontalrule", "H", ["hr"], false);
        f("source", "displaysource", "", "", false);
        return this.each(function () {
            function O() {
                var e, t;
                if (window.getSelection) {
                    return window.getSelection()
                } else if (document.selection && document.selection.createRange && document.selection.type != "None") {
                    return document.selection.createRange()
                }
            }

            function M(e, t) {
                var n, r = O();
                if (window.getSelection) {
                    if (r.anchorNode && r.getRangeAt) n = r.getRangeAt(0);
                    if (n) {
                        r.removeAllRanges();
                        r.addRange(n)
                    }
                    if (!u.match(/msie/)) {
                        document.execCommand("StyleWithCSS", false, false);
                        document.execCommand(e, false, t)
                    }
                } else if (document.selection && document.selection.createRange && document.selection.type != "None") {
                    n = document.selection.createRange();
                    n.execCommand(e, false, t)
                }
                H()
            }

            function _(t, n, r) {
                if (c.not(":focus")) c.focus();
                if (window.getSelection) {
                    var i = O(), s, o, u;
                    if (i.anchorNode && i.getRangeAt) {
                        s = i.getRangeAt(0);
                        o = document.createElement(t);
                        e(o).attr(n, r);
                        u = s.extractContents();
                        o.appendChild(u);
                        s.insertNode(o);
                        i.removeAllRanges();
                        if (n == "style") H(e(o), r); else H(e(o), false)
                    }
                } else if (document.selection && document.selection.createRange && document.selection.type != "None") {
                    var a = document.selection.createRange();
                    var f = a.htmlText;
                    var l = "<" + t + " " + n + '="' + r + '">' + f + "</" + t + ">";
                    document.selection.createRange().pasteHTML(l)
                }
            }

            function P(e) {
                var e = e[0];
                if (document.body.createTextRange) {
                    var t = document.body.createTextRange();
                    t.moveToElementText(e);
                    t.select()
                } else if (window.getSelection) {
                    var n = window.getSelection();
                    var t = document.createRange();
                    if (e != "undefined" && e != null) t.selectNodeContents(e);
                    n.removeAllRanges();
                    n.addRange(t)
                }
            }

            function H(e, t) {
                var n = D();
                n = n ? n : e;
                if (n && !t) {
                    if (n.parent().is("[style]")) n.attr("style", n.parent().attr("style"));
                    if (n.is("[style]")) n.find("*").attr("style", n.attr("style"))
                } else if (e && t && e.is("[style]")) {
                    var r = t.split(";");
                    r = r[0].split(":");
                    e.find("*").css(r[0], r[1])
                }
            }

            function B() {
                if (!f.data("sourceOpened")) {
                    var t = D();
                    var n = "http://";
                    F(true);
                    if (t) {
                        var r = t.prop("tagName").toLowerCase();
                        if (r == "a" && t.is("[href]")) {
                            n = t.attr("href");
                            t.attr(y, "")
                        } else {
                            _("a", y, "")
                        }
                    } else d.val(n).focus();
                    p.click(function (t) {
                        if (e(t.target).hasClass(o.css + "_linktypetext") || e(t.target).hasClass(o.css + "_linktypearrow")) I(true)
                    });
                    m.find("a").click(function () {
                        var t = e(this).attr(o.css + "-linktype");
                        m.data("linktype", t);
                        g.find("." + o.css + "_linktypetext").html(m.find("a:eq(" + m.data("linktype") + ")").text());
                        q(n);
                        I()
                    });
                    q(n);
                    d.val(n).bind("keypress keyup", function (e) {
                        if (e.keyCode == 13) {
                            j(s.find("[" + y + "]"));
                            return false
                        }
                    }).focus();
                    v.click(function () {
                        j(s.find("[" + y + "]"))
                    })
                } else F(false)
            }

            function j(t) {
                d.focus();
                P(t);
                t.removeAttr(y);
                if (m.data("linktype") != "2") M("createlink", d.val()); else {
                    M("insertImage", d.val());
                    c.find("img").each(function () {
                        var t = e(this).prev("a");
                        var n = e(this).next("a");
                        if (t.length > 0 && emptyLinks.html() == "") t.remove(); else if (n.length > 0 && n.html() == "") n.remove();
                        if (!e(this).is("[style*=float]")) e(this).css({"float": "left", margin: "0 10px 10px 0"})
                    })
                }
                F();
                V()
            }

            function F(e) {
                z("[" + y + "]:not([href])");
                s.find("[" + y + "][href]").removeAttr(y);
                if (e) {
                    f.data("linkOpened", true);
                    l.slideDown(100)
                } else {
                    f.data("linkOpened", false);
                    l.slideUp(100)
                }
                I()
            }

            function I(e) {
                if (e) m.stop(true, true).delay(100).slideToggle(100); else m.stop(true, true).delay(100).slideUp(100)
            }

            function q(e) {
                var t = m.data("linktype");
                if (t == "1" && (d.val() == "http://" || d.is("[value^=http://]") || !d.is("[value^=mailto]"))) d.val("mailto:"); else if (t != "1" && !d.is("[value^=http://]")) d.val("http://"); else d.val(e)
            }

            function R(t) {
                if (!f.data("sourceOpened")) {
                    if (t == "fSize") styleField = L; else if (t == "colors") styleField = A;
                    U(styleField, true);
                    styleField.find("a").click(function () {
                        var n = e(this).attr(o.css + "-styleval");
                        if (t == "fSize") {
                            styleType = "font-size";
                            n = n + o.funit
                        } else if (t == "colors") {
                            styleType = "color";
                            n = "rgb(" + n + ")"
                        }
                        var r = W(styleType);
                        _("span", "style", styleType + ":" + n + ";" + r);
                        U("", false);
                        e("." + o.css + "_title").remove();
                        V()
                    })
                } else U(styleField, false);
                F(false)
            }

            function U(e, t) {
                var n = "", r = [{d: "fsizeOpened", f: L}, {d: "cpallOpened", f: A}];
                if (e != "") {
                    for (var i = 0; i < r.length; i++) {
                        if (e == r[i]["f"]) n = r[i]
                    }
                }
                if (t) {
                    f.data(n["d"], true);
                    n["f"].slideDown(100);
                    for (var i = 0; i < r.length; i++) {
                        if (n["d"] != r[i]["d"]) {
                            f.data(r[i]["d"], false);
                            r[i]["f"].slideUp(100)
                        }
                    }
                } else {
                    for (var i = 0; i < r.length; i++) {
                        f.data(r[i]["d"], false);
                        r[i]["f"].slideUp(100)
                    }
                }
            }

            function z(t) {
                s.find(t).each(function () {
                    e(this).before(e(this).html()).remove()
                })
            }

            function W(e) {
                var t = D();
                if (t && t.is("[style]") && t.css(e) != "") {
                    var n = t.css(e);
                    t.css(e, "");
                    var r = t.attr("style");
                    t.css(e, n);
                    return r
                } else return ""
            }

            function X(e) {
                var t, n, r;
                t = e.replace(/\n/g, "").replace(/\r/g, "").replace(/\t/g, "").replace(/ /g, " ");
                n = [/\<div>(.*?)\<\/div>/ig, /\<br>(.*?)\<br>/ig, /\<br\/>(.*?)\<br\/>/ig, /\<strong>(.*?)\<\/strong>/ig, /\<em>(.*?)\<\/em>/ig];
                r = ["<p>$1</p>", "<p>$1</p>", "<p>$1</p>", "<b>$1</b>", "<i>$1</i>"];
                for (var i = 0; i < n.length; i++) {
                    t = t.replace(n[i], r[i])
                }
                return t
            }

            function V() {
                t.val(X(c.html()))
            }

            function J() {
                c.html(X(t.val()))
            }

            function K(t) {
                var n = false, r = D(), i;
                if (r) {
                    e.each(t, function (t, s) {
                        i = r.prop("tagName").toLowerCase();
                        if (i == s) n = true; else {
                            r.parents().each(function () {
                                i = e(this).prop("tagName").toLowerCase();
                                if (i == s) n = true
                            })
                        }
                    });
                    return n
                } else return false
            }

            function Q(t) {
                for (var n = 0; n < a.length; n++) {
                    if (o[a[n].name] && a[n].emphasis && a[n].tag != "") K(a[n].tag) ? f.find("." + o.css + "_tool_" + a[n].cls).addClass(h) : e("." + o.css + "_tool_" + a[n].cls).removeClass(h);
                    U("", false)
                }
            }

            var t = e(this);
            var n = e(this).is("[value]") || e(this).prop("tagName").toLowerCase() == "textarea" ? e(this).val() : e(this).html();
            var r = e(this).is("[name]") ? ' name="' + e(this).attr("name") + '"' : "";
            t.after('<div class="' + o.css + '" ></div>');
            var s = t.next("." + o.css);
            s.html('<div class="' + o.css + "_toolbar" + '" role="toolbar" unselectable></div><div class="' + o.css + '_linkform" style="display:none" role="dialog"></div><div class="' + o.css + "_editor" + '"></div>');
            var f = s.find("." + o.css + "_toolbar");
            var l = s.find("." + o.css + "_linkform");
            var c = s.find("." + o.css + "_editor");
            var h = o.css + "_tool_depressed";
            l.append('<div class="' + o.css + '_linktypeselect" unselectable></div> <input class="' + o.css + '_linkinput" type="text/css" value=""> <div class="' + o.css + '_linkbutton" unselectable>' + o.button + '</div> <div style="height:1px;float:none;clear:both"></div>');
            var p = l.find("." + o.css + "_linktypeselect");
            var d = l.find("." + o.css + "_linkinput");
            var v = l.find("." + o.css + "_linkbutton");
            p.append('<div class="' + o.css + '_linktypeview" unselectable></div><div class="' + o.css + '_linktypes" role="menu" unselectable></div>');
            var m = p.find("." + o.css + "_linktypes");
            var g = p.find("." + o.css + "_linktypeview");
            var y = o.css + "-setlink";
            var b = o.css + "-setfsize";
            c.after('<div class="' + o.css + "_source " + o.css + '_hiddenField"><textarea ' + r + ">" + n + "</textarea></div>");
            t.remove();
            var w = s.find("." + o.css + "_source");
            t = w.find("textarea");
            c.attr("contenteditable", "true").html(n);
            for (var E = 0; E < a.length; E++) {
                if (o[a[E].name]) {
                    var S = a[E].key.length > 0 ? o.titletext[E].hotkey != null && o.titletext[E].hotkey != "undefined" && o.titletext[E].hotkey != "" ? " (Ctrl+" + o.titletext[E].hotkey + ")" : "" : "";
                    var x = o.titletext[E].title != null && o.titletext[E].title != "undefined" && o.titletext[E].title != "" ? o.titletext[E].title + S : "";
                    f.append('<div class="' + o.css + "_tool " + o.css + "_tool_" + a[E].cls + '" role="button" data-tool="' + E + '" unselectable><a class="' + o.css + '_tool_icon" unselectable></a></div>');
                    f.find("." + o.css + "_tool[data-tool=" + E + "]").data({
                        tag: a[E].tag,
                        command: a[E].command,
                        emphasis: a[E].emphasis,
                        title: x
                    });
                    if (a[E].name == "fsize") {
                        f.find("." + o.css + "_tool_" + a[E].cls).append('<div class="' + o.css + '_fontsizes" unselectable style="position:absolute;display:none"></div>');
                        for (var T = 0; T < o.fsizes.length; T++) {
                            f.find("." + o.css + "_fontsizes").append("<a " + o.css + '-styleval="' + o.fsizes[T] + '" class="' + o.css + "_fontsize" + '" style="font-size:' + o.fsizes[T] + o.funit + '" role="menuitem" unselectable>Abcdefgh...</a>')
                        }
                    } else if (a[E].name == "color") {
                        f.find("." + o.css + "_tool_" + a[E].cls).append('<div class="' + o.css + '_cpalette" unselectable style="position:absolute;display:none"></div>');
                        for (var N = 0; N < i.length; N++) {
                            f.find("." + o.css + "_cpalette").append("<a " + o.css + '-styleval="' + i[N] + '" class="' + o.css + "_color" + '" style="background-color: rgb(' + i[N] + ')" role="gridcell" unselectable></a>')
                        }
                    }
                }
            }
            m.data("linktype", "0");
            for (var E = 0; E < 3; E++) {
                m.append("<a " + o.css + '-linktype="' + E + '" unselectable>' + o.linktypes[E] + "</a>");
                g.html('<div class="' + o.css + '_linktypearrow" unselectable></div><div class="' + o.css + '_linktypetext">' + m.find("a:eq(" + m.data("linktype") + ")").text() + "</div>")
            }
            var C = "";
            if (/msie/.test(u)) C = "-ms-"; else if (/chrome/.test(u) || /safari/.test(u) || /yandex/.test(u)) C = "-webkit-"; else if (/mozilla/.test(u)) C = "-moz-"; else if (/opera/.test(u)) C = "-o-"; else if (/konqueror/.test(u)) C = "-khtml-";
            s.find("[unselectable]").css(C + "user-select", "none").attr("unselectable", "on").on("selectstart mousedown", function (e) {
                e.preventDefault()
            });
            var k = f.find("." + o.css + "_tool");
            var L = f.find("." + o.css + "_fontsizes");
            var A = f.find("." + o.css + "_cpalette");
            var D = function () {
                var t, n;
                if (window.getSelection) {
                    n = getSelection();
                    t = n.anchorNode
                }
                if (!t && document.selection) {
                    n = document.selection;
                    var r = n.getRangeAt ? n.getRangeAt(0) : n.createRange();
                    t = r.commonAncestorContainer ? r.commonAncestorContainer : r.parentElement ? r.parentElement() : r.item(0)
                }
                if (t) {
                    return t.nodeName == "#text" ? e(t.parentNode) : e(t)
                } else return false
            };
            k.click(function (n) {
                if (e(this).data("command") == "displaysource" && !f.data("sourceOpened")) {
                    f.find("." + o.css + "_tool").addClass(o.css + "_hiddenField");
                    e(this).removeClass(o.css + "_hiddenField");
                    f.data("sourceOpened", true);
                    t.css("height", c.outerHeight());
                    w.removeClass(o.css + "_hiddenField");
                    c.addClass(o.css + "_hiddenField");
                    t.focus();
                    V();
                    F(false);
                    U("", false)
                } else {
                    if (!f.data("sourceOpened")) {
                        if (e(this).data("command") == "linkcreator") {
                            if (!f.data("linkOpened")) B(); else {
                                F(false)
                            }
                        } else if (e(this).data("command") == "fSize" && !e(n.target).hasClass(o.css + "_fontsize") || e(this).data("command") == "colors" && !e(n.target).hasClass(o.css + "_color")) {
                            R(e(this).data("command"))
                        } else {
                            if (c.not(":focus")) c.focus();
                            M(e(this).data("command"), null);
                            F(false);
                            U("", false);
                            e(this).data("emphasis") == true && !e(this).hasClass(h) ? e(this).addClass(h) : e(this).removeClass(h);
                            w.addClass(o.css + "_hiddenField");
                            c.removeClass(o.css + "_hiddenField");
                            V()
                        }
                    } else {
                        f.data("sourceOpened", false);
                        f.find("." + o.css + "_tool").removeClass(o.css + "_hiddenField");
                        w.addClass(o.css + "_hiddenField");
                        c.removeClass(o.css + "_hiddenField");
                        if (c.not(":focus")) c.focus()
                    }
                }
            }).hover(function (t) {
                if (o.title && e(this).data("title") != "" && (e(t.target).hasClass(o.css + "_tool") || e(t.target).hasClass(o.css + "_tool_icon"))) {
                    e("." + o.css + "_title").remove();
                    s.append('<div class="' + o.css + '_title"><div class="' + o.css + '_titleArrow"><div class="' + o.css + '_titleArrowIcon"></div></div><div class="' + o.css + '_titleText">' + e(this).data("title") + "</div></div>");
                    var n = e("." + o.css + "_title:first");
                    var r = n.find("." + o.css + "_titleArrowIcon");
                    var i = e(this).position();
                    var u = i.left + e(this).outerWidth() - n.outerWidth() / 2 - e(this).outerWidth() / 2;
                    var a = i.top + e(this).outerHeight() + 5;
                    n.delay(400).css({top: a, left: u}).fadeIn(200)
                }
            }, function () {
                e("." + o.css + "_title").remove()
            });
            c.bind("keypress keyup keydown drop cut copy paste DOMCharacterDataModified DOMSubtreeModified", function () {
                if (!f.data("sourceOpened")) e(this).trigger("change");
                I()
            }).bind("change", function () {
                if (!f.data("sourceOpened")) setTimeout(V, 0)
            }).keydown(function (e) {
                if (e.ctrlKey) {
                    for (var t = 0; t < a.length; t++) {
                        if (o[a[t].name] && e.keyCode == a[t].key.charCodeAt(0)) {
                            if (a[t].command != "" && a[t].command != "linkcreator") M(a[t].command, null); else if (a[t].command == "linkcreator") B();
                            return false
                        }
                    }
                }
            }).bind("mouseup keyup", Q).focus(function () {
                I()
            }).focusout(function () {
                k.removeClass(h);
                U("", false);
                I()
            });
            t.bind("keydown keyup", function () {
                setTimeout(J, 0);
                e(this).height(e(this)[0].scrollHeight);
                if (e(this).val() == "") e(this).height(0)
            })
        })
    }
})(jQuery)