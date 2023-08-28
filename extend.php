<?php

namespace DaleZ\fluentflarum;

use Flarum\Extend;
use Flarum\Frontend\Document;

return [
    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
            $document->head[] = '<script>(function () {
                function changeTitleColor(after) {
                    var r = document.querySelector(":root");
                    var rs = getComputedStyle(r);
                    if (rs.getPropertyValue("--colored-titlebar") === "false") {
                        var m = document.querySelector(`meta[name="theme-color"]`);
                        m.content = rs.getPropertyValue("--header-bg");
                        if (after) eval(after);
                    };
                }
            
                var promise = `new Promise(function (resolve) {
                    var id = setInterval(function () {
                        if (flarum) {
                            if (flarum.extensions) {
                                clearInterval(id);
                                resolve();
                            }
                        }
                    }, 500)
                }).then(function () {
                    if (flarum.extensions["fof-nightmode"]) {
                        document.addEventListener("fofnightmodechange", changeTitleColor);
                    }
                });`
            
                changeTitleColor(promise);
            })();</script>';
        })
        ->css(__DIR__.'/less/forum.less'),  
];