
/*
 * CometChat - Chat History Plugin
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccchathistory = (function () {

		var title = 'View chat history';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				baseUrl = $.cometchat.getBaseUrl();
				window.open (baseUrl+'plugins/chathistory/index.php?history='+id, 'chathistory',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=1, width=400,height=500"); 
			}

        };
    })();
 
})(jqcc);