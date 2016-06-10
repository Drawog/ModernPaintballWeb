var v = $('#pdesc').val();
console.log(v);

$(function() {
	// Will be [b]Bold![/b]
	var bbcode       = $("textarea").sceditor('instance').toBBCode('<strong>Bold!</strong>');
 
	// Will be <div><strong>Bold!</strong></div>
	var html         = $("textarea").sceditor('instance').fromBBCode($('#pdesc').val());
 
	// Will be <strong>Bold!</strong>
	var htmlFragment = $("textarea").sceditor('instance').fromBBCode('[b]Bold![b]', true);
});