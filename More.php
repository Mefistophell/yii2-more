<?php

/**
 * @link https://github.com/Mefistophell/yii2-more
 * @copyright Copyright (c) 2015 Mefistophell
 * @license http://www.yiiframework.com/license/
 */

namespace vova07\themes\site\widgets;

use Yii;

/**
 * ВИДЖЕТ More v.0.1
 * 
 * добавляет кнопку "Показать еще"
 * работает вместо постраничной навигации
 */
class More {
    
    /**
     * Количество выводимых записей
     */
    const quantity = 10;

    /**
     * Старт виджета
     * 
     * должен быть определен в теле элемента с rel="#more"
     * @var string 
     */
    public static $start = '<!-- start reviews -->';

    /**
     * Конец виджета
     * 
     * должен быть определен непосредственно перед закрывающим 
     * тегом для rel="#more"
     * @var string 
     */
    public static $end = '<!-- end reviews -->';

    /**
     * Виджет с кнопкой "Показать еще"
     * 
     * <?= More::end(Yii::$app->request->get('page')); ?>
     * @param string $page номер страницы
     * @param object $dataProvider объект $dataProvider
     * @return string выводит кнопку и js-скрипт
     */
    public static function widget($page, $dataProvider) {

        $count = $dataProvider->totalCount;
        $total = ceil($count / self::quantity);
        $page = empty($page) ? 2 : $page + 1;
        $items = ($page - 1) * self::quantity;

        if ($items > $count) {
            $items = $count;
        }

        echo '<div class="total" style="text-align:center">'
        . '<small>Показано: ' . $items . ' записей</small>'
        . '<small> из ' . $count . '</small>'
        . '</div>';

        if ($page > $total) {
            $js = '$(document).ready(function () {
                    $(".rm").remove();
                })';
            echo Yii::$app->view->registerJs($js);
            return;
        }

        echo '<div style="text-align:center"><br>'
        . '<button id = "more_'
        . $page
        . '" type = "submit" class = "btn btn-primary more">Показать еще</button></div>';

        $js = '$(document).ready(function () {
                $("body").on("click", ".more", function () {
                    var next_page = parseInt($(this).attr("id").split("_").pop());
                    url = window.location.origin + window.location.pathname;
                    $(this).addClass("rm");
                    $(".total").addClass("rm");
                    $.ajax({
                        type: "GET",
                        url: url,
                        data: "page=" + next_page + "&per-page=10",
                        success: function (msg) {
                            var html = canvart_strstr(msg, "<!-- start reviews -->");
                            html = canvart_strstr(html, "<!-- end reviews -->", true);
                            html = canvart_strstr(html, "<div");
                            $("div[rel=\'#more\']").append(html);
                            $(".rm").remove();
                            $("#preloader").fadeOut("fast");
                        }
                    });
                    $("#more_" + next_page).attr("id", "more_" + (next_page + 1));
                });
            });
            function canvart_strstr(haystack, needle, bool) {
                var pos = 0;
                pos = haystack.indexOf(needle);
                if (pos == -1) {
                    return false;
                } else {
                    if (bool) {
                        return haystack.substr(0, pos);
                    } else {
                        return haystack.slice(pos);
                    }
                }
            }';

        echo Yii::$app->view->registerJs($js);
    }

}
