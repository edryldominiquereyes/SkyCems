(function(){
    $('form').on('submit', function() {
        $('.button-prevent-multiple-submits').attr('disabled', 'true');
    })
})();