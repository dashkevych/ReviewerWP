(function( $ ) {
	'use strict';

	//Update row orders
	var simpleReviewUpdateOrder = function( table ) {
		table.find('> table > tbody > tr.review-row').each(function(i){
			$(this).children('td.order').html( i + 1 );
		});
	};

	//Display review table if needed
	var simpleReviewVisability = function( checkbox, table ) {
		if( checkbox.is(':checked') ) {
			table.show();
		} else {
			table.hide();
		}
	};

	$(document).ready(function(){
		var reviewTable = $('.simple-review-table');
		var visivilityCheckbox = $('#reviewerwp-post-visibility');

		simpleReviewVisability( visivilityCheckbox, reviewTable );

		visivilityCheckbox.on('click',function() {
			simpleReviewVisability( visivilityCheckbox, reviewTable );
		});

		//Add sortable functionality to the review table
		reviewTable.find('> table > tbody').sortable({
			stop : function (event, ui) {
				simpleReviewUpdateOrder( reviewTable );
			}
		});

		//Add new row to the review table
		reviewTable.find('.reviwerwp-add-row').on('click',function(e) {
			e.preventDefault();
			var rowID = reviewTable.find('> table > tbody > .review-row').size();
			var newRowHTML = reviewTable.find('> table > tbody > tr.review-clone').html().replace(/(=["]*[\w-\[\]]*?)(dummyindex)/g, '$1' + rowID );
			var newRow = $('<tr class="review-row"></tr>').append( newRowHTML );
			var beforeClone = reviewTable.find('> table > tbody > .review-clone');

			beforeClone.before( newRow );
			simpleReviewUpdateOrder( reviewTable );
		});

		//Remove row to the review table
		$(document).on('click', '.reviwerwp-remove-row', function(e) {
			e.preventDefault();
			$(this).parents('tr.review-row').remove();
			simpleReviewUpdateOrder( reviewTable );
		});
	});

})( jQuery );
