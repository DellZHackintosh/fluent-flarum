<?php

namespace DaleZ\fluent_flarum;

use Flarum\Extend;
use Flarum\Frontend\Document;
use Flarum\Settings\SettingsRepositoryInterface;

return [
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

            switch ($settings->get('dalez-fluent-flarum.background', 'solid')) {
                case 'solid':
                    # code...
                    break;

                case 'mica_accent':
                    # code...
                    break;
                
                default:
                    # code...
                    break;
            }

            $document->foot[] = '<script>(() => {const parser = new DOMParser();const dom = parser.parseFromString(`<div id="fluent-background"><svg></svg><div></div><div></div></div>`, \'text/html\');document.body.prepend(dom.body.firstElementChild);})();</script>';
        })
        ->css(__DIR__.'/oldless/forum.less'),  

        (new Extend\Settings())
            ->default('dalez-fluent-flarum.enableBeta', true)
            ->default('dalez-fluent-flarum.background', 'solid'),

        new Extend\Locales(__DIR__.'/locale'),
];