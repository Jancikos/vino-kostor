$('#show-menu-button').on('click', (e) => {
    $('#show-menu-button').fadeOut(1000);
    $('#hide-menu-button').fadeIn(500);

    $('#modal-menu').fadeIn ();
});
$('#hide-menu-button').on('click', (e) => {
    $('#hide-menu-button').fadeOut(1000);
    $('#show-menu-button').fadeIn(500);

    $('#modal-menu').fadeOut();
});