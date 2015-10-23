/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
    $("body").on("click", ".more", function () {
        var next_page = parseInt($(this).attr("id").split("_").pop());
        url = window.location.origin + window.location.pathname + "?page=";
        $(this).addClass("rm");
        $.ajax({
            type: "GET",
            url: "/",
            data: "page=" + next_page + "&per-page=10",
            success: function (msg) {
                var html = canvart_strstr(msg, "<!-- start reviews -->");
                html = canvart_strstr(html, "<!-- end reviews -->", true);
                html = canvart_strstr(html, "<div");
                $("div[rel='#more']").append(html);
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
}