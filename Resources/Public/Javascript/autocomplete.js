$(document).ready(function () {
	$("#tx-mmforum-tag-autocomplete")
	.bind( "keydown", function( event ) {
		if ( event.keyCode === $.ui.keyCode.TAB &&
			$( this ).data( "ui-autocomplete" ).menu.active ) {
			event.preventDefault();
		}
	})
	.autocomplete({
		minLength: 0,
		delay: 1000,
		source: function( request, response ) {
			$.getJSON( "index.php?id=2&eID=mm_forum&tx_mmforum_ajax[controller]=Tag&tx_mmforum_ajax[action]=autoComplete&tx_mmforum_ajax[value]="+extractLast( request.term ), {
			}, response );
		},
		search: function() {
			// custom minLength
			var term = extractLast( this.value );
			if ( term.length < 2 ) {
				return false;
			}
		},
		focus: function() {
			// prevent value inserted on focus
			return false;
		},
		select: function( event, ui ) {
			var terms = split( this.value );
			// remove the current input
			terms.pop();
			// add the selected item
			terms.push( ui.item.value );
			// add placeholder to get the comma-and-space at the end
			terms.push( "" );
			this.value = terms.join( ", " );
			return false;
		}
	});
});


function split( val ) {
	return val.split( /,\s*/ );
}
function extractLast( term ) {
	return split( term ).pop();
}