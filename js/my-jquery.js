var showWidth = 1;
	
if(showWidth == 1){
	$(document).ready(function (){
		$(window).resize(function(){
			var width = $(window).width();
			document.getElementById("output_width").innerHTML="Window Width:" +width.toString();
		});
	});
}

$(document).ready(function(){
	$("#test").click(function(){
		var width = $(window).width();
		if(width > 750){
			$("#myPan").slideToggle("slow");
		}
		else
		{
			$(".navbar-toggle").trigger( "click" );
		}
	});
});

$(document).ready(function(){
	$.ajax({
	  url: "info/get_info",
	  method: "get",
	  success: function(data){
		$("#myPan").html(data);
	  }
	});
});

$(document).ready(function(){
    $.ajax({
	  url: "news/get_votes",
	  method: "get",
	  success: function(data){
        var obj = jQuery.parseJSON(data);
        var i = 0;
        var aux = "";
        for(i = 0; i < obj.length; i++)
        {
            if(obj[i].likeNews == 1 && obj[i].dislikeNews == 0)
            {
                 $("#l" + obj[i].id).css("color", "red");
            }

            if(obj[i].likeNews == 0 && obj[i].dislikeNews == 1)
            {
                $("#d" + obj[i].id).css("color", "red");
            }
        }
	  }
	});
});