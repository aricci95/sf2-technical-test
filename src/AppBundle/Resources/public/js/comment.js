$( document ).ready(function() {
    refresh();

    $("#search_form").submit(function(event) {
        event.preventDefault();
        refresh();
    });
});


function refresh() {
    $("#user_list").css('opacity', '0.5');

    $url = 'search';

    if ($('#search_login').val()) {
        $url += '/' + $('#search_login').val();
    }

    $.get($url, function( data ) {
        $('#user_list').html(data)
        $("#user_list").css('opacity', '1');
    });
}
