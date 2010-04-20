/*
 * CometChat 
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

	var timestamp = 0;
	var currentroom = 0;
	var heartbeatTimer;
	var minHeartbeat = 3000;
	var maxHeartbeat = 12000;
	var heartbeatTime = minHeartbeat;
	var heartbeatCount = 1;
	var todaysDate = new Date();
	var todaysDay = todaysDate.getDate();

	function chatboxKeydown(event,chatboxtextarea) {
		if(event.keyCode == 13 && event.shiftKey == 0)  {
			var message = $(chatboxtextarea).val();
			message = message.replace(/^\s+|\s+$/g,"");

			if (currentroom != 0) {
 
				$(chatboxtextarea).val('');
				$(chatboxtextarea).css('height','18px');
				$(".cometchat_tabcontenttext").css('height','265px');
				$(chatboxtextarea).css('overflow-y','hidden');
				$(chatboxtextarea).focus();
				if (message != '') {
					$.post("chatrooms.php?action=sendmessage", {message: message, currentroom: currentroom} , function(data){				
						if (data) {
							addMessage('1', message, '1', '1', data,1,Math.floor(new Date().getTime()/1000));
							$(".cometchat_tabcontenttext").scrollTop($(".cometchat_tabcontenttext")[0].scrollHeight);
						}

					});
				}
			} else {
				$(chatboxtextarea).val(message);
				alert('Please select a chatroom');
			}

			return false;
		} 
	}

	function createChatroom(){
		var name = prompt("Please enter the chatroom name", "");
		if (name != '' && name != null) {
			name = name.replace(/^\s+|\s+$/g,"");
			$.post("chatrooms.php?action=createchatroom", {name: name} , function(data){				
				if (data) {
					$("#cometchat_userlist_"+currentroom).removeClass("cometchat_chatroomselected");
					if (name.length > 14) {
						name = name.substr(0,14)+'...';
					}
					$("#chatrooms").append('<div id="cometchat_userlist_'+data+'" class="cometchat_userlist cometchat_chatroomselected" onmouseover="jQuery(this).addClass(\'cometchat_userlist_hover\');" onmouseout="jQuery(this).removeClass(\'cometchat_userlist_hover\');" onclick="javascript:chatroom(\''+data+'\');" ><span class="cometchat_userscontentname">'+name+' (1)</span></div>');
					currentroom = data;
					timestamp = 0;
					replaceHtml("cometchat_tabcontenttext",'<div></div>');
					clearTimeout(heartbeatTimer);
					chatHeartbeat();	
				}

			});
		}		
	}

	function getTimeDisplay(ts) {
		var ap = "am";
		var hour = ts.getHours();
		var minute = ts.getMinutes();
		
		var date = ts.getDate();
		var month = ts.getMonth();
		
		if (hour > 11) { ap = "pm"; }
		if (hour > 12) { hour = hour - 12; }
		if (hour == 0) { hour = 12; }
		if (hour < 10) { hour   = hour; }
		if (minute < 10) { minute = "0" + minute; }

		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

		var type = 'th';
		if (date == 1 || date == 21 || date == 31) { type = 'st'; }
		else if (date == 2 || date == 22) { type = 'nd'; }
		else if (date == 3 || date == 23) { type = 'rd'; }

		if (date != todaysDay) {
				return '<span class="cometchat_ts">('+hour+":"+minute+ap+' '+date+type+' '+months[month]+')</span>';
			} else {
				return '<span class="cometchat_ts">('+hour+":"+minute+ap+')</span>';
		}

	}

	function addMessage(id,incomingmessage,self,old,incomingid,selfadded,sent) {

			fromname = "Me";
			separator = ':&nbsp;&nbsp;';

			if ($("#cometchat_message_"+incomingid).length > 0) { 
				$("#cometchat_message_"+incomingid+' .cometchat_chatboxmessagecontent').html(incomingmessage);
			} else {

				sentdata = '';

				if (sent != null) {
					var ts = new Date(sent * 1000);
					sentdata = getTimeDisplay(ts);
				}

				if (fromname.indexOf(" ") != -1) {
					fromname = fromname.slice(0,fromname.indexOf(" "));
				}
				
				$("#cometchat_tabcontenttext").append('<div class="cometchat_chatboxmessage" id="cometchat_message_'+incomingid+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong>'+separator+'</span><span class="cometchat_chatboxmessagecontent">'+incomingmessage+'</span>'+sentdata+'</div>');
									
			}
			
	}


	function chatboxKeyup(event,chatboxtextarea) {
	 
		var adjustedHeight = chatboxtextarea.clientHeight;
		var maxHeight = 94;

		if (maxHeight > adjustedHeight) {
			adjustedHeight = Math.max(chatboxtextarea.scrollHeight, adjustedHeight);
			if (maxHeight)
				adjustedHeight = Math.min(maxHeight, adjustedHeight);
			if (adjustedHeight > chatboxtextarea.clientHeight) {
				$(chatboxtextarea).css('height',adjustedHeight+4 +'px');
				$(".cometchat_tabcontenttext").css('height',283-(adjustedHeight+4) +'px');
			}
		} else {
			$(chatboxtextarea).css('overflow-y','auto');
		}			 

		$(".cometchat_tabcontenttext").scrollTop($(".cometchat_tabcontenttext")[0].scrollHeight);
	}

	function chatroom(id) {
		$("#cometchat_userlist_"+currentroom).removeClass("cometchat_chatroomselected");
		$("#cometchat_userlist_"+id).addClass("cometchat_chatroomselected");
		currentroom = id;
		timestamp = 0;
		replaceHtml("cometchat_tabcontenttext",'<div></div>');
		replaceHtml("show_users",'<div></div>');
		clearTimeout(heartbeatTimer);
		chatHeartbeat();		
	}


	function chatHeartbeat(){	

			$.ajax({
				url: "chatrooms.php?action=heartbeat",
				data: {timestamp: timestamp, currentroom: currentroom},
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
			 
						$.each(data, function(type,item){
 
							if (type == 'chatrooms') {

								var temp = '';
		
								$.each(item, function(i,room) {

									if (room.name.length > 14) {
										longname = room.name.substr(0,14)+'...';
									} else {
										longname = room.name;
									}
							
									if (room.status == 'available') {
										onlineNumber++;
									}

									var selected = '';

									if (currentroom == room.id) {
										selected = ' cometchat_chatroomselected';
									}
									
									temp += '<div id="cometchat_userlist_'+room.id+'" class="cometchat_userlist'+selected+'" onmouseover="jQuery(this).addClass(\'cometchat_userlist_hover\');" onmouseout="jQuery(this).removeClass(\'cometchat_userlist_hover\');" onclick="javascript:chatroom(\''+room.id+'\');" ><span class="cometchat_userscontentname">'+longname+' ('+room.online+')</span></div>';
							
							
								});	

								if (temp != '') {
									replaceHtml("chatrooms",'<div>'+temp+'</div>');
								}

							}

							if (type == 'usernames') {

								var temp = '';
		
								$.each(item, function(i,userlist) {

									if (userlist.name.length > 14) {
										longname = userlist.name.substr(0,14)+'...';
									} else {
										longname = userlist.name;
									}

									temp += '<div class="ccm_userlist" onclick="javascript:parent.jqcc.cometchat.chatWith(\''+userlist.userid+'\');" onmouseover="jQuery(this).addClass(\'cometchat_userlist_hover\');" onmouseout="jQuery(this).removeClass(\'cometchat_userlist_hover\');"><span  class="cometchat_userscontentname">'+longname+'</span></div>';
							
							
								});	

								if (temp != '') {
									replaceHtml("show_users",'<div>'+temp+'</div>');
								}

							}
		
							if (type == 'messages') {

								var temp = '';

								$.each(item, function(i,incoming) {
									timestamp = incoming.id;
								
									var fromname = incoming.from;
								
									if ($("#cometchat_message_"+incoming.id).length > 0) { 
										$("#cometchat_message_"+incoming.id+' .cometchat_chatboxmessagecontent').html(incoming.message);
									} else {
										var ts = new Date(incoming.sent * 1000);

										if (fromname.indexOf(" ") != -1) {
											fromname = fromname.slice(0,fromname.indexOf(" "));
										}

										if (incoming.fromid != 0) {								
											temp += ('<div class="cometchat_chatboxmessage" id="cometchat_message_'+incoming.id+'"><span class="cometchat_chatboxmessagefrom"><strong><a href="javascript:void(0)" onclick="javascript:parent.jqcc.cometchat.chatWith(\''+incoming.fromid+'\');">'+fromname+'</a></strong>:&nbsp;&nbsp;</span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+getTimeDisplay(ts)+'</div>');
										} else {
											temp += ('<div class="cometchat_chatboxmessage" id="cometchat_message_'+incoming.id+'"><span class="cometchat_chatboxmessagefrom"><strong>'+fromname+'</strong>:&nbsp;&nbsp;</span><span class="cometchat_chatboxmessagecontent">'+incoming.message+'</span>'+getTimeDisplay(ts)+'</div>');
										}
									}

								});

								heartbeatCount = 1;
								heartbeatTime = minHeartbeat;
								
								if (temp != '') {
									replaceHtml('cometchat_tabcontenttext', document.getElementById('cometchat_tabcontenttext').innerHTML+'<div>'+temp+'</div>');
									$("#cometchat_tabcontenttext").scrollTop(50000);
									setTimeout('$("#cometchat_tabcontenttext").scrollTop(50000)',100);
								}
							}
						});
						

					}

					heartbeatCount++;
					
					if (heartbeatCount > 4) {
						heartbeatTime *= 2;
						heartbeatCount = 1;
					}

					if (heartbeatTime > maxHeartbeat) {
						heartbeatTime = maxHeartbeat;
					}

					clearTimeout(heartbeatTimer);
					heartbeatTimer = setTimeout( function() { chatHeartbeat(); },heartbeatTime);

			
			}});

		}


$(document).ready(function() {

	chatHeartbeat();

	$(".cometchat_textarea").keydown(function(event) {
		return chatboxKeydown(event,this);
	});

	$(".cometchat_textarea").keyup(function(event) {
		return chatboxKeyup(event,this);
	});

});


 function replaceHtml(el, html) {
	var oldEl = typeof el === "string" ? document.getElementById(el) : el;
	/*@cc_on // Pure innerHTML is slightly faster in IE
		oldEl.innerHTML = html;
		return oldEl;
	@*/
	var newEl = oldEl.cloneNode(false);
	newEl.innerHTML = html;
	oldEl.parentNode.replaceChild(newEl, oldEl);
	/* Since we just removed the old element from the DOM, return a reference
	to the new element, which can be used to restore variable references. */
	return newEl;
};