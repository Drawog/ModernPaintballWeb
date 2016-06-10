$('select').on('change', function() {
    var valG1 = $('#genre1').val();
    var valG2 = $('#type').val();
    
    var dataG1 = (valG1 == '') ? '' : '[genre1="'+valG1 +'"]';
    var dataG2 = (valG2 == '') ? '' : '[type="'+valG2 +'"]';
    
    $('div.box.post').hide();
    $('div.box.post'+dataG1+dataG2).show();
});