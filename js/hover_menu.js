	$(function(){
		
			$("#connect-button").css({
				opacity: 0.3
			});
			$("#races-button").css({
				opacity: 0.3
			});
		
			$("#page-wrap div.button").hover(function(){
				
				$clicked = $(this);
				
				// if the button is not already "transformed" AND is not animated
				if ($clicked.css("opacity") != "1" && $clicked.is(":not(animated)")) {
					
					$clicked.animate({
						opacity: 1,
						borderWidth: 2
					}, 200 );
					
					// each button div MUST have a "xx-button" and the target div must have an id "xx" 
					var idToLoad = $clicked.attr("id").split('-');
					
					//we search trough the content for the visible div and we fade it out
					$("#content").find("div:visible").fadeOut("fast", function(){
						//once the fade out is completed, we start to fade in the right div
						$(this).parent().find("#"+idToLoad[0]).fadeIn();
					})
				}
				
				//we reset the other buttons to default style
				$clicked.siblings(".button").animate({
					opacity: 0.5,
					borderWidth: 0
				}, 200 );
				
			});
		});
		