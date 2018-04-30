require('touch-dnd/touch-dnd.js');

var queryDict = {}
location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})

$( document ).ready(function() {
	console.log( "ready!" );
	$.get("backend/data.php", { voter : queryDict['voter']}).done(function(data) {
		var list = JSON.parse(data).list;
		console.log(list);
		$.each(list, function(i) {
			$('#vote_list').append('<li id="' + this.id + '">' + this.name + '</li>' + "\n");
		});
	});
});

$(function() {
$('#vote_list').sortable({}).on('sortable:update', function() {
	var votes = [];
	$('#vote_list').children('li').each(function () {
		var id = $(this).attr('id');
		if ('__ph0' != id) {
    		votes.push(id);
    	}
	});
	var data = { voter : queryDict['voter'], votes : votes};
	console.log(data);
	$.post("backend/vote.php", JSON.stringify(data), null, 'json');
})
});
 