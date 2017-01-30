$(document).ready(function() {
	selectionControlDisable();
	
	$("#select-all").click(function() {
		var checked_status = this.checked;
		$('.cell-select').each(function() {
			this.checked = checked_status;
			if($(this).is(":checked")){
		        $(this).parent().parent().addClass("row-selected"); 
				selectionControlEnable();
		    }else{
		        $(this).parent().parent().removeClass("row-selected");  
				selectionControlDisable();
		    }
		});
	});

	$('.cell-select').change(function() {
		$('#select-all').attr('checked', false);
		selectionControlDisable();
		
		if($(this).is(":checked")){
	        $(this).parent().parent().addClass("row-selected"); 
	    }else{
	        $(this).parent().parent().removeClass("row-selected");  
	    }
	
		$('.cell-select').each( function() {
			if ($(this).is(":checked")) {
				selectionControlEnable();
			};
		});
	});
	
	$('#_SelectionAction').change( function() {
		if ($(this).find('option:selected').val()) {
			selectionControlEnable();
		} else {
			selectionExecuteDisable();
		};
	});
	
	function selectionControlDisable () {
		$('.selection-control').attr('disabled', 'disabled');
		$('#_SelectionExecute').addClass('mh-button-disabled');
		$('#mh-table-selection-action').hide();
	}
	
	function selectionControlEnable () {
        $('.selection-control').removeAttr('disabled'); 
		$('#_SelectionExecute').removeClass('mh-button-disabled');	
		$('#mh-table-selection-action').show();
		if (!$('#_SelectionAction').find('option:selected').val()) {
			selectionExecuteDisable();
		}
	}
	
	function selectionExecuteDisable () {
		$('#_SelectionExecute').attr('disabled', 'disabled');
		$('#_SelectionExecute').addClass('mh-button-disabled');
	}
});
