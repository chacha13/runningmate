/*
 * CometChat - Clear Conversation Plugin
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccclearconversation = (function () {

		var title = 'Clear conversation';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				if ($("#cometchat_user_"+id+"_popup .cometchat_tabcontenttext").html() != '') {
					baseUrl = $.cometchat.getBaseUrl();
					$.post(baseUrl+'plugins/clearconversation/index.php?action=clear', {clearid: id});
					$("#cometchat_user_"+id+"_popup .cometchat_tabcontenttext").html('');
				}
			}

        };
    })();
 
})(jqcc);