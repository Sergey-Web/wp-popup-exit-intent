jQuery(document).ready(function($) {
    $('#modalPotential').modal();
    $('html').mouseleave(function(e) {
        if (e.pageY - $(window).scrollTop() <= 1) {
            $.ajax({
                type: 'POST',
                data: {
                    action: 'exit-popup',
                    security: popupAjax.nonce,
                },
                url: popupAjax.url,
                success: function(res) {
                    if(res === '') {
                        return;
                    }
                    console.log(res);
                    $('#modalPotential').modal('open');
                },
                error: function(res) {
                    console.log('error');
                }
            });
        }

        $('#startQuiz').on('click', function(){
            $.ajax({
                type: 'POST',
                data: {
                    action: 'exit-popup',
                    security: popupAjax.nonce,
                    click: 'startQuiz'
                },
                url: popupAjax.url,
                success: function(res) {
                    if(res === '') {
                        return;
                    }
                    console.log(res);
                },
                error: function(res) {
                    console.log('error');
                }
            });
        })
    });
});