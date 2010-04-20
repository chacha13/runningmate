/*
 * CometChat 
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.cometchatspy = function(){

		var heartbeatTimer;
		var timeStamp = '0';		

		function chatHeartbeat(){	
			
			$.ajax({
				url: "index.php?action=spydata",
				data: {timestamp: timeStamp},
				type: 'post',
				cache: false,
				dataFilter: function(data) {
					if (typeof (JSON) !== 'undefined' && typeof (JSON.parse) === 'function')
					  return JSON.parse(data);
					else
					  return eval('(' + data + ')');
				},
				success: function(data) {
					if (data) {
						var htmlappend = '';

						$.each(data, function(type,item){
							if (type == 'timestamp') {
								timeStamp = item;
							}

							if (type == 'online') {
								$('#online').html(item);
							}

							if (type == 'messages') {
								$.each(item, function(i,incoming) {
									htmlappend = '<div class="chat"><div class="chatrequest2">'+incoming.fromu+' -> '+incoming.tou+'</div><div class="chatmessage2" >'+incoming.message+'</div><div style="clear:both"></div></div>' + htmlappend;

								});
							}
						});

						if (htmlappend != '') {
							$("#data").prepend(htmlappend);
							$('div.message').fadeIn(2000);
							$('div.message:gt(19)').remove(); 
						}
					}
					
				clearTimeout(heartbeatTimer);
				heartbeatTimer = setTimeout( function() { chatHeartbeat(); },3000);
				
			}});

		}

		chatHeartbeat();

	} 
  
})(jQuery);

