<?php

namespace DaleZ\fluent_flarum;

use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;

return resolve(SettingsRepositoryInterface::class)->get('dalez-fluent-flarum.disableBeta', false) ? [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

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

        new Extend\Locales(__DIR__.'/locale'),
] : [
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),

    (new Extend\Frontend('forum'))
        ->content(function (Document $document) {
            $settings = resolve(SettingsRepositoryInterface::class);

            if (!($settings->get('theme_colored_header'))) {
                /*
                $document->head[] = '<script>(function () {
                    var r = getComputedStyle(document.querySelector(":root"));
    
                    function changeTitleColor() {
                        var m = document.querySelector(`meta[name="theme-color"]`);
                        m.content = r.getPropertyValue("--header-bg");
                    }
                
                    changeTitleColor();
                    new Promise(function (resolve) {
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
                */
                $document->head[] = '<script>(function(){function a(){var a=document.querySelector(`meta[name="theme-color"]`);a.content=b.getPropertyValue("--header-bg")}var b=getComputedStyle(document.querySelector(":root"));a(),new Promise(function(a){var b=setInterval(function(){flarum&&flarum.extensions&&(clearInterval(b),a())},500)}).then(function(){flarum.extensions["fof-nightmode"]&&document.addEventListener("fofnightmodechange",a)})})();</script>';
            }
        })
        ->css(__DIR__.'/oldless/forum.less')
        ->css(__DIR__.'/less/forum.less')
        ->js(__DIR__.'/js/dist/forum.js'),  

        (new Extend\Settings())
            ->default('dalez-fluent-flarum.disableBeta', false)
            ->default('dalez-fluent-flarum.background', 'solid')
            ->registerLessConfigVar('dalez-fluent-flarum-background', 'dalez-fluent-flarum.background', function ($value) {
                return $value ? str_replace("_", "", $value) : 'solid';
            }),

        new Extend\Locales(__DIR__.'/locale'),
];