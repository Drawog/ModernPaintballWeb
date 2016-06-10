/**
 * Created by Drawog on 31/03/2016.
 */




var bbC =function() {

    $('textarea').sceditor({
        plugins: 'bbcode',
        style: 'minified/jquery.sceditor.default.min.css',
        toolbar : 'bold,italic,underline,strike,subscript,superscript|left,center,right,justify|font,size|youtube',
        locale : 'fr',
        height: '300px',

    });

    var html = $('textarea').sceditor('instance').fromBBCode('[b]Bold![b]',true);
    $('#bddcode').append(html)

};

$(bbC);