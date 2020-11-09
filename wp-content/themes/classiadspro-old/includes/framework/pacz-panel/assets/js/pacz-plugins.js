"use strict";
! function(o) {
    o(document).ready(function() {
        var t = o(".pacz-plugins"),
            c = o(".pacz-admin-btn");
        t.on("click", '.pacz-admin-btn[data-plugin-action="install"]', function(t) {
            if (t.preventDefault(), !o(".pacz-admin-btn").hasClass("installing")) {
                var n = o(this),
                    a = n.attr("href").split("&"),
                    e = {
                        action: "pacz_install_plugin",
                        plugin: a[1].substr(a[1].lastIndexOf("=") + 1, a[1].length),
                        "tgmpa-install": "install-plugin",
                        "tgmpa-nonce": a[3].substr(a[3].lastIndexOf("=") + 1, a[3].length),
                        page: "install-required-plugins"
                    };
                n.addClass("installing"), c.css("opacity", "0.5"), n.css("opacity", "1"), o.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: e
                }).done(function(t) {
                    if (n.closest(".wsw-install-pacz-plus").length) {
                        var a = location.href;
                        a.includes("step") ? (a = a.slice(0, -1), a += 2) : a += "&step=2", location.href = a
                    }
                    c.css("opacity", "1"), n.closest(".pacz-plugin").length ? n.closest(".row-actions").replaceWith('<div class="row-actions visible active"><span class="activate"><a href="#" class="button pacz-admin-btn">Activated</a></span></div>') : n.removeClass("installing").attr("data-plugin-action", "deactivate").attr("href", t.substr(t.lastIndexOf("paczi") + 6, t.length)).text("Deactivate").closest(".theme").addClass("active")
                }).fail(function() {
                    alert("Something went wrong! Reload page and try again.")
                })
            }
        }), t.on("click", '.pacz-admin-btn[data-plugin-action="update"]', function(t) {
            if (t.preventDefault(), !o(".pacz-admin-btn").hasClass("installing")) {
                var n = o(this),
                    a = n.attr("href").split("&"),
                    e = {
                        action: "pacz_update_plugin",
                        plugin: a[1].substr(a[1].lastIndexOf("=") + 1, a[1].length),
                        "tgmpa-update": "update-plugin",
                        "tgmpa-nonce": a[3].substr(a[3].lastIndexOf("=") + 1, a[3].length),
                        page: "install-required-plugins"
                    };
                n.addClass("installing"), c.css("opacity", "0.5"), n.css("opacity", "1"), o.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: e
                }).done(function(t) {
                    if (n.closest(".wsw-install-pacz-plus").length) {
                        var a = location.href;
                        a.includes("step") ? (a = a.slice(0, -1), a += 2) : a += "&step=2", location.href = a
                    }
                    c.css("opacity", "1"), n.closest(".row-actions").find(".update").remove(), n.closest(".pacz-plugin").length ? n.closest(".row-actions").replaceWith('<div class="row-actions visible active"><span class="activate"><a href="#" class="button pacz-admin-btn">Activated</a></span></div>') : n.removeClass("installing").attr("data-plugin-action", "deactivate").attr("href", t.substr(t.lastIndexOf("paczi") + 6, t.length)).text("Deactivate").closest(".theme").addClass("active")
                }).fail(function() {
                    alert("Something went wrong! Reload page and try again.")
                })
            }
        }), t.on("click", '.pacz-admin-btn[data-plugin-action="activate"]', function(t) {
            if (t.preventDefault(), !o(".pacz-admin-btn").hasClass("installing")) {
                var n = o(this),
                    a = n.attr("href").split("&"),
                    e = {
                        action: "pacz_activate_plugin",
                        plugin: a[1].substr(a[1].lastIndexOf("=") + 1, a[1].length),
                        "tgmpa-activate": "activate-plugin",
                        "tgmpa-nonce": a[3].substr(a[3].lastIndexOf("=") + 1, a[3].length)
                    };
                n.addClass("installing"), c.css("opacity", "0.5"), n.css("opacity", "1"), o.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: e,
                    success: function(t) {
                        if (n.closest(".wsw-install-pacz-plus").length) {
                            var a = location.href;
                            a.includes("step") ? (a = a.slice(0, -1), a += 2) : a += "&step=2", location.href = a
                        }
                        c.css("opacity", "1"), n.closest(".pacz-plugin").length ? n.closest(".row-actions").replaceWith('<div class="row-actions visible active"><span class="activate"><a href="#" class="button pacz-admin-btn">Activated</a></span></div>') : n.removeClass("installing").attr("data-plugin-action", "deactivate").attr("href", t).text("Deactivate").closest(".theme").addClass("active")
                    }
                })
            }
        }), t.on("click", '.pacz-admin-btn[data-plugin-action="deactivate"]', function(t) {
            if (t.preventDefault(), !o(".pacz-admin-btn").hasClass("installing")) {
                var a = o(this),
                    n = a.attr("href").split("&"),
                    e = {
                        action: "pacz_deactivate_plugin",
                        plugin: n[1].substr(n[1].lastIndexOf("=") + 1, n[1].length),
                        "tgmpa-deactivate": "deactivate-plugin",
                        "tgmpa-nonce": n[3].substr(n[3].lastIndexOf("=") + 1, n[3].length)
                    };
                a.addClass("installing"), c.css("opacity", "0.5"), a.css("opacity", "1"), o.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: e,
                    success: function(t) {
                        c.css("opacity", "1"), a.removeClass("installing").attr("data-plugin-action", "activate").attr("href", t).text("Activate").closest(".theme").removeClass("active")
                    }
                })
            }
        }), o(".whi-install-plugins").on("click", function(t) {
            t.preventDefault();
            var a = o(this),
                n = a.parent().next(".pacz-plugins"),
                i = [];
            n.find(".pacz-plugin:not(:hidden)").each(function(t, a) {
                var n = o(this).find(".pacz-admin-btn"),
                    e = n.attr("href"),
                    s = n.data("plugin-action");
                null != e && "#" != e && i.push({
                    elem: n[0],
                    href: e,
                    pluginAction: s
                })
            }), i.length ? function a(n, e) {
                if (!n.length) return void e.css({
                    background: "linear-gradient(95deg, #6fe08a 0%, #58cf74 50%, #36cb58 100%)",
                    "box-shadow": "0 5px 10px -5px #4cbf67",
                    "pointer-events": "none"
                });
                if (o(".pacz-admin-btn").hasClass("installing")) return;
                var s = o(n[0].elem);
                var t = n[0].pluginAction;
                var i = s.attr("href").split("&");
                var l;
                "install" == t ? l = {
                    action: "pacz_install_plugin",
                    plugin: i[1].substr(i[1].lastIndexOf("=") + 1, i[1].length),
                    "tgmpa-install": "install-plugin",
                    "tgmpa-nonce": i[3].substr(i[3].lastIndexOf("=") + 1, i[3].length),
                    page: "install-required-plugins"
                } : "activate" == t ? l = {
                    action: "pacz_activate_plugin",
                    plugin: i[1].substr(i[1].lastIndexOf("=") + 1, i[1].length),
                    "tgmpa-activate": "activate-plugin",
                    "tgmpa-nonce": i[3].substr(i[3].lastIndexOf("=") + 1, i[3].length)
                } : "update" == t ? l = {
                    action: "pacz_update_plugin",
                    plugin: i[1].substr(i[1].lastIndexOf("=") + 1, i[1].length),
                    "tgmpa-update": "update-plugin",
                    "tgmpa-nonce": i[3].substr(i[3].lastIndexOf("=") + 1, i[3].length),
                    page: "install-required-plugins"
                } : (n.shift(), a(n, e));
                s.addClass("installing");
                c.css("opacity", "0.5");
                s.css("opacity", "1");
                o.ajax({
                    type: "GET",
                    url: ajaxurl,
                    data: l
                }).done(function(t) {
                    c.css("opacity", "1"), s.closest(".pacz-plugin").length ? s.closest(".row-actions").replaceWith('<div class="row-actions visible active"><span class="activate"><a href="#" class="button pacz-admin-btn">Activated</a></span></div>') : s.removeClass("installing").attr("data-plugin-action", "activate").attr("href", t.substr(t.lastIndexOf("paczi") + 6, t.length)).text("Activate").closest(".theme").addClass("active"), n.shift(), a(n, e)
                }).fail(function() {
                    alert("Something went wrong! Reload page and try again.")
                })
            }(i, a) : a.css({
                background: "linear-gradient(95deg, #6fe08a 0%, #58cf74 50%, #36cb58 100%)",
                "box-shadow": "0 5px 10px -5px #4cbf67",
                "pointer-events": "none"
            })
        })
    })
}(jQuery);