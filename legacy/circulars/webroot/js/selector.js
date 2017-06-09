$(document).ready(function() {
	initCourseSelector();
	$('input[id^="AddresseeStage"]').click(function() {
		var checked = onlyOneChecked('AddresseeStage');
		if (!checked) {
			hideLevels(true);
			hideClasses(true);
		} else {
			showLevels(checked);
        }
        buildTextResponse();
	});
	
	$('input[id^="AddresseeLevel"]').click(function() {
		var stage = onlyOneChecked('AddresseeStage');
		if (!stage) {
			return false;
        }
        var checked = onlyOneChecked('AddresseeLevel');
		if (!checked) {
			hideClasses(true);
		} else {
			showClasses(stage);
        }
        buildTextResponse();
	});
	
	$('input[id^="AddresseeClass"]').click(function() {
		buildTextResponse();
	});
	
	$('#AddresseeGroup').change(function () {
		buildTextResponse();
	});
	
	$('#AddresseeFreetext').change(function () {
		if (this.checked) {
			hideStages(true);
			hideLevels(true);
			hideClasses(true);
			$('.course-selector-field').hide();
		} else {
			showControls('AddresseeStage');
			$('.course-selector-field').show();
        }
    })
	
});

function initCourseSelector () {
	var state = $('#AddresseeFreetext').prop('checked');
	if (state) {
		hideStages(true);
		hideLevels(true);
		hideClasses(true);
		$('.course-selector-field').hide();
		return;
    }
    showControls('AddresseeStage');
	initLevels();
	initClasses();
}

function buildTextResponse () {
	var stages = getStages('spa');
	var gStages = getStages('glg');
	var levels = getLevels();
	var classes = getClasses();
	var group = $('#AddresseeGroup :selected').text();
	if (classes) {
		levels = levels + ' ' + classes;
	}
	if (!levels) {
		response = stages;
	} else {
		response = levels + ' de ' + stages;
    }
    response = group + ' de ' + response;
	$('#CircularAddresseeSpa').val(response);
	
	if (!levels) {
		response = gStages;
	} else {
		response = levels + ' de ' + gStages;
    }
    response = group + ' de ' + response;
	$('#CircularAddresseeGlg').val(response);
}

function initLevels () {
	var stage = onlyOneChecked('AddresseeStage');
	hideLevels(false);
    if (!stage) {
        return
    }
    showLevels(stage);

}

function hideStages(clear) {
	for (var i=0; i < 4; i++) {
		var s = Math.pow(2, i);
		var id = '#AddresseeStage'+s;
		if (clear) {
            $(id).attr('checked', false);

        }
        $(id).parent().hide();
    }
}

function initClasses () {
	var stage = onlyOneChecked('AddresseeStage');
	hideClasses(false);
    if (!stage) {
        return
    }
    var level = onlyOneChecked('AddresseeLevel');
    if (!level) {
        return
    }
    showClasses(stage);

}

function getStages (lang) {
    var checked = [];
    var stages = [];
	stages[1] = 'E. Infantil';
	stages[2] = 'E. Primaria';
	stages[4] = 'ESO';
	stages[8] = 'Bachillerato';
	if (lang =='glg') {
		stages[8] = 'Bacharelato';
    }
    $('input:checkbox[id^="AddresseeStage"]:checked').each(function () {
		checked.push(stages[$(this).val()]);
	});
	return checked.join(', ');
}

function getLevels () {
    var checked = [];
    var levels = [];
	levels[1] = '1º';
	levels[2] = '2º';
	levels[4] = '3º';
	levels[8] = '4º';
	levels[16] = '5º';
	levels[32] = '6º';
	$('input:checkbox[id^="AddresseeLevel"]:checked').each(function () {
		checked.push(levels[$(this).val()]);
	});
	return checked.join(', ');
}

function getClasses () {
    var checked = [];
    var classes = [];
	classes[1] = 'A';
	classes[2] = 'B';
	classes[4] = 'C';
	$('input:checkbox[id^="AddresseeClass"]:checked').each(function () {
		checked.push(classes[$(this).val()]);
	});
	return checked.join(', ');
}

function onlyOneChecked(id) {
	var total = 0;
	var checked = false;
	$('input[id^="'+id+'"]').each(function(){
		if (this.checked) {
			total = total+1;
			checked = this.id
        }
    });
	if (total !=1) {
		return false;
    }
    return checked;
}

function showLevels(stage) {
	var maxLevel;
	if (stage == 'AddresseeStage1') {
		maxLevel = 3;
    }
    if (stage == 'AddresseeStage2') {
		maxLevel = 6;
    }
    if (stage == 'AddresseeStage4') {
		maxLevel = 4;
    }
    if (stage == 'AddresseeStage8') {
		maxLevel = 2;
    }
    for (var i = 0; i < maxLevel; i++) {
		var s = Math.pow(2, i);
		var id = '#AddresseeLevel'+s;
		$(id).parent().show();
    }
}

function hideLevels(clear) {
	for (var i=0; i < 6; i++) {
		var s = Math.pow(2, i);
		var id = '#AddresseeLevel'+s;
		if (clear) {
            $(id).attr('checked', false);

        }
        $(id).parent().hide();
    }
}

function uncheckControls (id) {
	$('input[id^="'+id+'"]:checkbox').attr('checked', false);
}

function showControls (id) {
	$('input[id^="'+id+'"]:checkbox').parent().show();
}

function hideControls (id) {
	$('input[id^="'+id+'"]:checkbox').parent().hide();
}

function showClasses (stage) {
	var maxLevel = 3;
	if (stage == 'AddresseeStage8') {
		maxLevel = 2;
    }
    for (var i = 0; i < maxLevel; i++) {
		var s = Math.pow(2, i);
		var id = '#AddresseeClass'+s;
		$(id).parent().show();
    }
}

function hideClasses (clear) {
	for (var i=0; i < 3; i++) {
		var s = Math.pow(2, i);
		var id = '#AddresseeClass'+s;
		if (clear) {
			$(id).attr('checked', false);
        }
        $(id).parent().hide();
    }
}
