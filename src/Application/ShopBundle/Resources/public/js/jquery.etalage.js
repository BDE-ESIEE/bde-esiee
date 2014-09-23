/*
 * Title: jQuery Etalage plugin
 * Author: Berend de Jong, Frique
 * Author URI: http://www.frique.me/
 * Version: 1.3.3 (20130226.1)
 */

(function (a) {
    a.fn.etalage = function (b) {
        var c = a.extend({
            align: "left",
            thumb_image_width: 300,
            thumb_image_height: 400,
            source_image_width: 900,
            source_image_height: 1200,
            zoom_area_width: 600,
            zoom_area_height: "justify",
            zoom_area_distance: 10,
            zoom_easing: true,
            click_to_zoom: false,
            zoom_element: "auto",
            show_descriptions: true,
            description_location: "bottom",
            description_opacity: 0.7,
            small_thumbs: 3,
            smallthumb_inactive_opacity: 0.4,
            smallthumb_hide_single: true,
            smallthumb_select_on_hover: false,
            smallthumbs_position: "bottom",
            magnifier_opacity: 0.5,
            magnifier_invert: true,
            show_icon: true,
            icon_offset: 20,
            hide_cursor: false,
            show_hint: false,
            hint_offset: 15,
            speed: 600,
            autoplay: true,
            autoplay_interval: 6000,
            keyboard: true,
            right_to_left: false,
            click_callback: function () {
                return true
            },
            change_callback: function () {
                return true
            }
        }, b);
        a.each(this, function () {
            var aD = a(this);
            if (aD.is("ul") && aD.children("li").length && aD.find("img.etalage_source_image").length) {
                var aa, Z, O, G, an, s, f, aO, aI, at, aN = aD.attr("id"),
                    aV = Math.floor(c.speed * 0.7),
                    az = Math.round(c.speed / 100),
                    af = false,
                    y = false,
                    e = false,
                    al = true,
                    z = false,
                    w = 0,
                    ai = 0,
                    ah = 0,
                    W = 0,
                    V = 0,
                    aC = "hori";
                if (typeof aN === "undefined" || !aN) {
                    aN = "[no id]"
                }
                if (c.smallthumbs_position === "left" || c.smallthumbs_position === "right") {
                    aC = "vert"
                }
                if (typeof a.browser === "object" && a.browser.msie) {
                    if (a.browser.version < 9) {
                        al = false;
                        if (a.browser.version < 7) {
                            e = true
                        }
                    }
                }
                aD.addClass("etalage").show();
                var v = aD.children("li").addClass("etalage_thumb");
                v.first().show().addClass("etalage_thumb_active");
                var p = v.length,
                    aG = c.autoplay;
                if (p < 2) {
                    aG = false
                }
                if (c.align === "right") {
                    aD.addClass("etalage_right")
                }
                a.each(v, function (aX) {
                    aX += 1;
                    var a0 = a(this),
                        j = a0.find(".etalage_thumb_image").removeAttr("alt").show(),
                        aZ = a0.find(".etalage_source_image"),
                        aY = a0.find("a");
                    a0.data("id", aX).addClass("thumb_" + aX);
                    if (!j.length && aZ.length) {
                        a0.prepend('<img class="etalage_thumb_image" src="' + aZ.attr("src") + '" />')
                    } else {
                        if (!j.length && !aZ.length) {
                            a0.remove()
                        }
                    } if (aY.length) {
                        a0.find(".etalage_thumb_image").data("anchor", aY.attr("href"))
                    }
                });
                var ar = v.find(".etalage_thumb_image").css({
                    width: c.thumb_image_width,
                    height: c.thumb_image_height
                }).show();
                a.each(ar, function () {
                    a(this).data("src", this.src)
                });
                var aL = a('<li class="etalage_magnifier"><div><img /></div></li>').appendTo(aD),
                    Y = aL.children("div"),
                    h = Y.children("img");
                var D = a('<li class="etalage_icon">&nbsp;</li>').appendTo(aD);
                if (c.show_icon) {
                    D.show()
                }
                var q;
                if (c.show_hint) {
                    q = a('<li class="etalage_hint">&nbsp;</li>').appendTo(aD).show()
                }
                var I, r = c.zoom_element;
                if (r !== "auto" && r && a(r).length) {
                    I = a(r).addClass("etalage_zoom_area").html('<div><img class="etalage_zoom_img" /></div>')
                } else {
                    r = "auto";
                    I = a('<li class="etalage_zoom_area"><div><img class="etalage_zoom_img" /></div></li>').appendTo(aD)
                }
                var U = I.children("div"),
                    ak;
                if (al) {
                    ak = a('<img class="etalage_zoom_preview" />').css({
                        width: c.source_image_width,
                        height: c.source_image_height,
                        opacity: 0.3
                    }).prependTo(U).show()
                }
                var ay = U.children(".etalage_zoom_img").css({
                    width: c.source_image_width,
                    height: c.source_image_height
                });
                var aw;
                if (c.show_descriptions) {
                    aw = a('<div class="etalage_description' + ((c.right_to_left) ? " rtl" : "") + '"></div>').prependTo(I)
                }
                var aM, l, aR, t, x, ag = c.small_thumbs;
                if (p > 1 || !c.smallthumb_hide_single) {
                    aM = a('<li class="etalage_small_thumbs"><ul></ul></li>').appendTo(aD);
                    l = aM.children("ul");
                    a.each(ar, function () {
                        var i = a(this);
                        O = i.data("src");
                        G = i.parents(".etalage_thumb").data("id");
                        a('<li><img class="etalage_small_thumb" src="' + O + '" /></li>').data("thumb_id", G).appendTo(l)
                    });
                    aR = l.children("li").css({
                        opacity: c.smallthumb_inactive_opacity
                    });
                    if (ag < 3) {
                        ag = 3
                    }
                    if (p > ag) {
                        O = ar.eq(p - 1).data("src");
                        G = v.eq(p - 1).data("id");
                        a('<li class="etalage_smallthumb_first"><img class="etalage_small_thumb" src="' + O + '" /></li>').data("src", O).data("thumb_id", G).css({
                            opacity: c.smallthumb_inactive_opacity
                        }).prependTo(l);
                        O = ar.eq(0).data("src");
                        G = v.eq(0).data("id");
                        a('<li><img class="etalage_small_thumb" src="' + O + '" /></li>').data("src", O).data("thumb_id", G).css({
                            opacity: c.smallthumb_inactive_opacity
                        }).appendTo(l);
                        aR = l.children("li");
                        aR.eq(ag - 1).addClass("etalage_smallthumb_last");
                        aR.eq(1).addClass("etalage_smallthumb_active").css({
                            opacity: 1
                        })
                    } else {
                        aR.eq(0).addClass("etalage_smallthumb_active").css({
                            opacity: 1
                        })
                    }
                    a.each(aR, function (j) {
                        a(this).data("id", (j + 1))
                    });
                    t = aR.children("img");
                    x = aR.length;
                    if (aC === "vert") {
                        aR.addClass("vertical")
                    }
                }
                if (c.magnifier_invert) {
                    an = 1
                } else {
                    an = c.magnifier_opacity
                }
                var aK = parseInt(v.css("borderLeftWidth"), 10) + parseInt(v.css("borderRightWidth"), 10) + parseInt(ar.css("borderLeftWidth"), 10) + parseInt(ar.css("borderRightWidth"), 10),
                    X = parseInt(v.css("marginLeft"), 10) + parseInt(v.css("marginRight"), 10),
                    A = parseInt(v.css("paddingLeft"), 10) + parseInt(v.css("paddingRight"), 10) + parseInt(ar.css("marginLeft"), 10) + parseInt(ar.css("marginRight"), 10) + parseInt(ar.css("paddingLeft"), 10) + parseInt(ar.css("paddingRight"), 10),
                    L = c.thumb_image_width + aK + X + A,
                    M = c.thumb_image_height + aK + X + A,
                    aB = 0,
                    N = 0,
                    au = 0,
                    ad = 0,
                    aA = 0,
                    n = 0,
                    aE = 0;
                if (p > 1 || !c.smallthumb_hide_single) {
                    aB = parseInt(aR.css("borderLeftWidth"), 10) + parseInt(aR.css("borderRightWidth"), 10) + parseInt(t.css("borderLeftWidth"), 10) + parseInt(t.css("borderRightWidth"), 10);
                    N = parseInt(aR.css("marginTop"), 10);
                    au = parseInt(aR.css("paddingLeft"), 10) + parseInt(aR.css("paddingRight"), 10) + parseInt(t.css("marginLeft"), 10) + parseInt(t.css("marginRight"), 10) + parseInt(t.css("paddingLeft"), 10) + parseInt(t.css("paddingRight"), 10);
                    if (aC === "vert") {
                        aA = Math.round((M - ((ag - 1) * N)) / ag) - (aB + au);
                        ad = Math.round((c.thumb_image_width * aA) / c.thumb_image_height);
                        n = ad + aB + au;
                        aE = aA + aB + au
                    } else {
                        ad = Math.round((L - ((ag - 1) * N)) / ag) - (aB + au);
                        aA = Math.round((c.thumb_image_height * ad) / c.thumb_image_width);
                        n = ad + aB + au;
                        aE = aA + aB + au
                    }
                }
                var d = parseInt(I.css("borderTopWidth"), 10),
                    ax = parseInt(c.zoom_area_distance, 10),
                    H = parseInt(I.css("paddingTop"), 10),
                    R, aW;
                if ((c.zoom_area_width - (d * 2) - (H * 2)) > c.source_image_width) {
                    R = c.source_image_width
                } else {
                    R = c.zoom_area_width - (d * 2) - (H * 2)
                } if (c.zoom_area_height === "justify") {
                    aW = (M + N + aE) - (d * 2) - (H * 2)
                } else {
                    aW = c.zoom_area_height - (d * 2) - (H * 2)
                } if (aW > c.source_image_height) {
                    aW = c.source_image_height
                }
                var aT, ap, u, ao;
                if (c.show_descriptions) {
                    aT = parseInt(aw.css("borderLeftWidth"), 10) + parseInt(aw.css("borderRightWidth"), 10);
                    ap = parseInt(aw.css("marginLeft"), 10) + parseInt(aw.css("marginRight"), 10);
                    u = parseInt(aw.css("paddingLeft"), 10) + parseInt(aw.css("paddingRight"), 10);
                    ao = R - aT - ap - u
                }
                var aJ;
                if (e) {
                    aJ = a('<iframe marginwidth="0" marginheight="0" scrolling="no" frameborder="0" src="javascript:\'<html></html>\'"></iframe>').css({
                        position: "absolute",
                        zIndex: 1
                    }).prependTo(I)
                }
                var Q = parseInt(aL.css("borderTopWidth"), 10),
                    aH = parseInt(v.css("borderTopWidth"), 10) + parseInt(v.css("marginTop"), 10) + parseInt(v.css("paddingTop"), 10) + parseInt(ar.css("borderTopWidth"), 10) + parseInt(ar.css("marginTop"), 10) - Q,
                    aj = ar.offset().left - aD.offset().left - Q;
                if (c.smallthumbs_position === "left") {
                    aj = aj + n + N
                } else {
                    if (c.smallthumbs_position === "top") {
                        aH = aH + aE + N
                    }
                }
                var T = Math.round(R * (c.thumb_image_width / c.source_image_width)),
                    P = Math.round(aW * (c.thumb_image_height / c.source_image_height)),
                    K = aH + c.thumb_image_height - P,
                    o = aj + c.thumb_image_width - T,
                    ac = Math.round(T / 2),
                    ab = Math.round(P / 2),
                    F, B;
                if (c.show_hint) {
                    F = parseInt(c.hint_offset, 10) + parseInt(q.css("marginTop"), 10);
                    B = parseInt(c.hint_offset, 10) + parseInt(q.css("marginRight"), 10);
                    if (c.smallthumbs_position === "right") {
                        B = B - n - N
                    }
                }
                if (aC === "vert") {
                    aO = L + N + n;
                    aD.css({
                        width: aO,
                        height: M
                    })
                } else {
                    aO = L;
                    aD.css({
                        width: aO,
                        height: M + N + aE
                    })
                } if (c.show_icon) {
                    at = {
                        top: M - D.outerHeight(true) - parseInt(c.icon_offset, 10),
                        left: parseInt(c.icon_offset, 10)
                    };
                    if (c.smallthumbs_position === "left") {
                        at.left = n + N + parseInt(c.icon_offset, 10)
                    } else {
                        if (c.smallthumbs_position === "top") {
                            at.top += aE + N
                        }
                    }
                    D.css(at)
                }
                if (c.show_hint) {
                    q.css({
                        margin: 0,
                        top: -F,
                        right: -B
                    })
                }
                h.css({
                    margin: 0,
                    padding: 0,
                    width: c.thumb_image_width,
                    height: c.thumb_image_height
                });
                Y.css({
                    margin: 0,
                    padding: 0,
                    width: T,
                    height: P
                });
                at = {
                    margin: 0,
                    padding: 0,
                    left: (o - aj) / 2,
                    top: (K - aH) / 2
                };
                if (c.smallthumbs_position === "left") {
                    at.left = "+=" + n + N
                } else {
                    if (c.smallthumbs_position === "top") {
                        at.top = "+=" + aE + N
                    }
                }
                aL.css(at).hide();
                U.css({
                    width: R,
                    height: aW
                });
                at = {
                    margin: 0,
                    opacity: 0
                };
                if (c.align === "right" && r === "auto") {
                    at.left = -(R + (d * 2) + (H * 2) + ax)
                } else {
                    if (r === "auto") {
                        at.left = aO + ax
                    }
                }
                I.css(at).hide();
                if (c.show_descriptions) {
                    at = {
                        width: ao,
                        bottom: H,
                        left: H,
                        opacity: c.description_opacity
                    };
                    if (c.description_location === "top") {
                        at.top = H;
                        at.bottom = "auto"
                    }
                    aw.css(at).hide()
                }
                if (p > 1 || !c.smallthumb_hide_single) {
                    if (aC === "vert") {
                        at = {
                            top: 0,
                            height: M
                        };
                        if (c.smallthumbs_position === "left") {
                            v.css({
                                left: n + N
                            })
                        } else {
                            at.marginLeft = L + N
                        }
                        aM.css(at);
                        l.css({
                            height: (aE * x) + (x * N) + 100
                        });
                        t.css({
                            width: ad,
                            height: aA
                        }).attr("height", aA);
                        aR.css({
                            margin: 0,
                            marginBottom: N
                        })
                    } else {
                        at = {
                            width: L
                        };
                        if (c.smallthumbs_position === "top") {
                            v.css({
                                top: aE + N
                            })
                        } else {
                            at.top = M + N
                        }
                        aM.css(at);
                        l.css({
                            width: (n * x) + (x * N) + 100
                        });
                        t.css({
                            width: ad,
                            height: aA
                        }).attr("width", ad);
                        aR.css({
                            margin: 0,
                            marginRight: N
                        })
                    } if (aC === "vert") {
                        aI = ((aE * ag) + ((ag - 1) * N)) - M
                    } else {
                        aI = ((n * ag) + ((ag - 1) * N)) - L
                    } if (aI > 0) {
                        for (aa = 1; aa <= (x - 1); aa = aa + (ag - 1)) {
                            Z = 1;
                            for (Z; Z <= aI; Z += 1) {
                                if (aC === "vert") {
                                    aR.eq(aa + Z - 1).css({
                                        marginBottom: (N - 1)
                                    })
                                } else {
                                    aR.eq(aa + Z - 1).css({
                                        marginRight: (N - 1)
                                    })
                                }
                            }
                        }
                    } else {
                        if (aI < 0) {
                            for (aa = 1; aa <= (x - 1); aa = aa + (ag - 1)) {
                                Z = 1;
                                for (Z; Z <= (-aI); Z += 1) {
                                    if (aC === "vert") {
                                        aR.eq(aa + Z - 1).css({
                                            marginBottom: (N + 1)
                                        });
                                        l.css({
                                            height: parseInt(l.css("height"), 10) + 1
                                        })
                                    } else {
                                        aR.eq(aa + Z - 1).css({
                                            marginRight: (N + 1)
                                        });
                                        l.css({
                                            width: parseInt(l.css("width"), 10) + 1
                                        })
                                    }
                                }
                            }
                        }
                    }
                }
                if (c.show_icon && !c.magnifier_invert) {
                    aL.css({
                        background: aL.css("background-color") + " " + D.css("background-image") + " center no-repeat"
                    })
                }
                if (c.hide_cursor) {
                    aL.add(D).css({
                        cursor: "none"
                    })
                }
                if (e) {
                    aJ.css({
                        width: U.css("width"),
                        height: U.css("height")
                    })
                }
                var av = v.first().find(".etalage_thumb_image"),
                    am = v.first().find(".etalage_source_image");
                if (c.magnifier_invert) {
                    h.attr("src", av.data("src")).show()
                }
                if (al) {
                    ak.attr("src", av.data("src"))
                }
                ay.attr("src", am.attr("src"));
                if (c.show_descriptions) {
                    f = am.attr("title");
                    if (f) {
                        aw.html(f).show()
                    }
                }
                var C = function () {
                    if (s) {
                        clearInterval(s);
                        s = false
                    }
                };
                var k = function () {
                    if (s) {
                        C()
                    }
                    s = setInterval(function () {
                        aq()
                    }, c.autoplay_interval)
                };
                var S = function () {
                    aL.stop().fadeTo(aV, an);
                    D.stop().animate({
                        opacity: 0
                    }, aV);
                    I.stop().show().animate({
                        opacity: 1
                    }, aV);
                    if (c.magnifier_invert) {
                        av.stop().animate({
                            opacity: c.magnifier_opacity
                        }, aV)
                    }
                    if (aG) {
                        C()
                    }
                };
                var aS = function () {
                    aL.stop().fadeOut(c.speed);
                    D.stop().animate({
                        opacity: 1
                    }, c.speed);
                    I.stop().animate({
                        opacity: 0
                    }, c.speed, function () {
                        a(this).hide()
                    });
                    if (c.magnifier_invert) {
                        av.stop().animate({
                            opacity: 1
                        }, c.speed, function () {
                            if (c.click_to_zoom) {
                                z = false
                            }
                        })
                    }
                    clearTimeout(w);
                    if (aG) {
                        k()
                    }
                };
                var g = function (aZ, aX) {
                    var j, aY, i = aD.find(".etalage_smallthumb_active").removeClass("etalage_smallthumb_active");
                    aZ.addClass("etalage_smallthumb_active");
                    aL.stop().hide();
                    I.stop().hide();
                    if (!aX) {
                        af = true;
                        i.stop(true, true).animate({
                            opacity: c.smallthumb_inactive_opacity
                        }, aV);
                        aZ.stop(true, true).animate({
                            opacity: 1
                        }, aV, function () {
                            af = false
                        })
                    }
                    aD.find(".etalage_thumb_active").removeClass("etalage_thumb_active").stop().animate({
                        opacity: 0
                    }, c.speed, function () {
                        a(this).hide()
                    });
                    j = v.filter(".thumb_" + aZ.data("thumb_id")).addClass("etalage_thumb_active").show().stop().css({
                        opacity: 0
                    }).animate({
                        opacity: 1
                    }, c.speed);
                    av = j.find(".etalage_thumb_image");
                    am = j.find(".etalage_source_image");
                    if (c.magnifier_invert) {
                        h.attr("src", av.data("src"))
                    }
                    if (al) {
                        ak.attr("src", av.data("src"))
                    }
                    ay.attr("src", am.attr("src"));
                    if (c.show_descriptions) {
                        f = am.attr("title");
                        if (f) {
                            aw.html(f).show()
                        } else {
                            aw.hide()
                        }
                    }
                    if (aG) {
                        C();
                        k()
                    }
                    aY = aZ.data("id");
                    if (p >= ag) {
                        aY--
                    }
                    ae(aY)
                };
                var E = function (aY, j, i, aX) {
                    a.each(aR, function () {
                        var a0 = a(this),
                            aZ = {
                                opacity: c.smallthumb_inactive_opacity
                            };
                        if (a0.data("id") === aX.data("id")) {
                            aZ.opacity = 1
                        }
                        if (aC === "vert") {
                            aZ.top = "-=" + aY
                        } else {
                            aZ.left = "-=" + aY
                        }
                        a0.animate(aZ, aV, "swing", function () {
                            if (af) {
                                aX.addClass("etalage_smallthumb_active");
                                af = false
                            }
                        })
                    });
                    g(aX, true)
                };
                var aU = function () {
                    var aY = W - ai,
                        aX = V - ah,
                        j = -aY / az,
                        i = -aX / az;
                    ai = ai - j;
                    ah = ah - i;
                    if (aY < 1 && aY > -1) {
                        ai = W
                    }
                    if (aX < 1 && aX > -1) {
                        ah = V
                    }
                    ay.css({
                        left: ai,
                        top: ah
                    });
                    if (al) {
                        ak.css({
                            left: ai,
                            top: ah
                        })
                    }
                    if (aY > 1 || aX > 1 || aY < 1 || aX < 1) {
                        w = setTimeout(function () {
                            aU()
                        }, 25)
                    }
                };
                var J = function () {
                    var i;
                    if (c.magnifier_invert) {
                        aD.find(".etalage_thumb_active").mouseleave()
                    }
                    if (!c.right_to_left) {
                        i = aD.find(".etalage_smallthumb_active").prev();
                        if (!i.length) {
                            i = aR.last()
                        }
                    } else {
                        i = aD.find(".etalage_smallthumb_active").next();
                        if (!i.length) {
                            i = aR.first()
                        }
                    }
                    i.click()
                };
                var aq = function () {
                    var i;
                    if (c.magnifier_invert) {
                        aD.find(".etalage_thumb_active").mouseleave()
                    }
                    if (!c.right_to_left) {
                        i = aD.find(".etalage_smallthumb_active").next();
                        if (!i.length) {
                            i = aR.first()
                        }
                    } else {
                        i = aD.find(".etalage_smallthumb_active").prev();
                        if (!i.length) {
                            i = aR.last()
                        }
                    }
                    i.click()
                };
                var m = function (aY) {
                    if (p <= ag) {
                        aY = aY - 1
                    }
                    var a2 = aR.eq(aY);
                    if (a2.length && !af) {
                        var a1 = aD.find(".etalage_smallthumb_active"),
                            aX = a1.data("id") - 1,
                            j;
                        if (aX > aY) {
                            y = aX - aY;
                            var aZ = aD.find(".etalage_smallthumb_first"),
                                a3 = aZ.data("id");
                            if (aY < a3) {
                                j = aX - a3;
                                y = y - j;
                                aZ.click()
                            } else {
                                g(a2, false)
                            }
                        } else {
                            if (aX < aY) {
                                y = aY - aX;
                                var a0 = aD.find(".etalage_smallthumb_last"),
                                    i = a0.data("id") - 1;
                                if (aY >= i) {
                                    j = i - aX - 1;
                                    y = y - j;
                                    a0.click()
                                } else {
                                    g(a2, false)
                                }
                            }
                        }
                        y = false
                    }
                };
                window[aN + "_previous"] = function () {
                    J()
                };
                window[aN + "_next"] = function () {
                    aq()
                };
                window[aN + "_show"] = function (i) {
                    m(i)
                };
                var aF = function (i) {
                    if (!c.click_callback(i, aN)) {
                        return false
                    }
                    if (typeof etalage_click_callback === "function") {
                        etalage_click_callback(i, aN);
                        return false
                    }
                    return true
                };
                var ae = function (i) {
                    if (c.change_callback(i, aN)) {
                        if (typeof etalage_change_callback === "function") {
                            etalage_change_callback(i, aN)
                        }
                    }
                };
                v.add(aL).add(D).mouseenter(function () {
                    if (c.show_hint) {
                        q.hide()
                    }
                    if (!c.click_to_zoom || z) {
                        S()
                    }
                }).mouseleave(function () {
                    aS()
                });
                var aQ = -(c.source_image_width - R),
                    aP = -(c.source_image_height - aW);
                v.add(aL).add(D).mousemove(function (a1) {
                    var j = Math.round(a1.pageX - av.offset().left + aj),
                        i = Math.round(a1.pageY - av.offset().top + aH);
                    var a0 = (j - ac),
                        aZ = (i - ab);
                    if (a0 < aj) {
                        a0 = aj
                    }
                    if (a0 > o) {
                        a0 = o
                    }
                    if (aZ < aH) {
                        aZ = aH
                    }
                    if (aZ > K) {
                        aZ = K
                    }
                    aL.css({
                        left: a0,
                        top: aZ
                    });
                    if (c.magnifier_invert) {
                        var aY = a0 - aj,
                            aX = aZ - aH;
                        h.css({
                            left: -aY,
                            top: -aX
                        })
                    }
                    W = -((a0 - aj) * (1 / (c.thumb_image_width / c.source_image_width)));
                    V = -((aZ - aH) * (1 / (c.thumb_image_height / c.source_image_height)));
                    if (W < aQ) {
                        W = aQ
                    }
                    if (V < aP) {
                        V = aP
                    }
                    if (c.zoom_easing) {
                        clearTimeout(w);
                        aU()
                    } else {
                        if (al) {
                            ak.css({
                                left: W,
                                top: V
                            })
                        }
                        ay.css({
                            left: W,
                            top: V
                        })
                    }
                });
                if (p > 1 || !c.smallthumb_hide_single) {
                    aD.delegate(".etalage_smallthumb_first", "click", function () {
                        if (!af || y) {
                            var a3 = a(this),
                                aX = 1,
                                j = 0,
                                a0, a4, a1, a2, aZ;
                            if (y) {
                                aX = y
                            }
                            af = true;
                            for (var aY = 0; aY < aX; aY += 1) {
                                a0 = a3.removeClass("etalage_smallthumb_first");
                                a4 = aD.find(".etalage_smallthumb_last").removeClass("etalage_smallthumb_last");
                                if (a3.prev().length) {
                                    a1 = a0.prev().addClass("etalage_smallthumb_first");
                                    a2 = a4.prev().addClass("etalage_smallthumb_last");
                                    aZ = a0
                                } else {
                                    a1 = aR.eq(x - ag).addClass("etalage_smallthumb_first");
                                    a2 = aR.eq(x - 1).addClass("etalage_smallthumb_last");
                                    aZ = a2.prev()
                                } if (aC === "vert") {
                                    j = a1.position().top
                                } else {
                                    j = a1.position().left
                                } if (a3.prev().length) {
                                    a3 = a3.prev()
                                }
                            }
                            E(j, a1, a2, aZ)
                        }
                    });
                    aD.delegate(".etalage_smallthumb_last", "click", function () {
                        if (!af || y) {
                            var a3 = a(this),
                                aX = 1,
                                j = 0,
                                a0, a4, a1, a2, aZ;
                            if (y) {
                                aX = y
                            }
                            af = true;
                            for (var aY = 0; aY < aX; aY += 1) {
                                a0 = aD.find(".etalage_smallthumb_first").removeClass("etalage_smallthumb_first");
                                a4 = a3.removeClass("etalage_smallthumb_last");
                                if (a3.next().length) {
                                    a1 = a0.next().addClass("etalage_smallthumb_first");
                                    a2 = a4.next().addClass("etalage_smallthumb_last");
                                    aZ = a4
                                } else {
                                    a1 = aR.eq(0).addClass("etalage_smallthumb_first");
                                    a2 = aR.eq(ag - 1).addClass("etalage_smallthumb_last");
                                    aZ = a1.next()
                                } if (aC === "vert") {
                                    j = a1.position().top
                                } else {
                                    j = a1.position().left
                                } if (a3.next().length) {
                                    a3 = a3.next()
                                }
                            }
                            E(j, a1, a2, aZ)
                        }
                    });
                    aR.click(function () {
                        var i = a(this);
                        if (!i.hasClass("etalage_smallthumb_first") && !i.hasClass("etalage_smallthumb_last") && !i.hasClass("etalage_smallthumb_active") && !af) {
                            g(i, false)
                        }
                    });
                    if (c.smallthumb_select_on_hover) {
                        aR.mouseenter(function () {
                            a(this).click()
                        })
                    }
                }
                if (c.click_to_zoom) {
                    v.click(function () {
                        z = true;
                        S()
                    })
                } else {
                    aL.click(function () {
                        var i = av.data("anchor");
                        if (i) {
                            if (aF(i)) {
                                window.location = i
                            }
                        }
                    })
                } if (p > 1 && c.keyboard) {
                    a(document).keydown(function (i) {
                        if (i.keyCode === 39 || i.keyCode === "39") {
                            if (!c.right_to_left) {
                                aq()
                            } else {
                                J()
                            }
                        }
                        if (i.keyCode === 37 || i.keyCode === "37") {
                            if (!c.right_to_left) {
                                J()
                            } else {
                                aq()
                            }
                        }
                    })
                }
                a(window).bind("load", function () {
                    v.css({
                        "background-image": "none"
                    });
                    I.css({
                        "background-image": "none"
                    });
                    if (al) {
                        al = false;
                        ak.remove()
                    }
                });
                if (aG) {
                    k()
                }
            }
        });
        return this
    }
})(jQuery);
