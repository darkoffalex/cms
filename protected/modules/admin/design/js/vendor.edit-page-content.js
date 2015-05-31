$(document).ready(function() {
//language change event
$("#styled-language-editor").on("change", function(){
	console.log(this.value);
		$(document).find("textarea").textarea({width : "100%"}); // reattach editor to textarea after ajax load.done;
});//end language change event
// undo button
$(".undo").click(function()
	{
		console.log("undo");
		return false;
	});//end undo button
});//end ready