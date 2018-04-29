//require('jquery');
require('touch-dnd/touch-dnd.js');

var queryDict = {}
location.search.substr(1).split("&").forEach(function(item) {queryDict[item.split("=")[0]] = item.split("=")[1]})



$(function() {
$('#example1').sortable({}).on('sortable:update', function() {
	var data = [];
	$('#example1').children('li').each(function () {
		var id = $(this).attr('id');
		if ('__ph0' != id) {
    		data.push(id);
    	}
	});
	console.log({ voter : queryDict['voter'], data : data});
	//$.post("voter/vote.php", data, null, 'json');
})
});
 