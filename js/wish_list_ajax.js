/**
 * loaded in protected\views\wish\_view.php to support picking up wishlist items
 */
$(document).ready(function () {
    $('.claim').click(function () {
        var wishid = $(this).attr('wishid');
        $.ajax({
            type: 'get',
            url: $(this).attr('url'),
            data: {"ajax": "1"},
            success: function (resp) {
                // $("ul.authors").append(resp);
                alert("wish #" + wishid + " " + resp);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert("ERROR: " + textStatus + ", " + errorThrown);
            }
        });

    });
});

