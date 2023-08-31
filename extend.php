<?php

namespace DaleZ\fluentflarum;

use Flarum\Extend;
use Flarum\Frontend\Document;

return [
    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
            $document->head[] = '<script>(function () {
                var r = getComputedStyle(document.querySelector(":root"));

                function changeTitleColor() {
                    if (r.getPropertyValue("--colored-titlebar") === "false") {
                        var m = document.querySelector(`meta[name="theme-color"]`);
                        m.content = r.getPropertyValue("--header-bg");
                    };
                }
            
                changeTitleColor();
                if (r.getPropertyValue("--colored-titlebar") === "false") new Promise(function (resolve) {
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
                });
            })();</script>';
        })
        ->css(__DIR__.'/less/forum.less'),  
];