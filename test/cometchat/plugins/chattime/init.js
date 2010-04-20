
/*
 * CometChat - Chat Time Plugin
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccchattime = (function () {

		var title = 'Show/hide time';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {

				if ($("#cometchat_user_"+id+"_popup .cometchat_ts").css('display') == 'none') {
					$("#cometchat_user_"+id+"_popup .cometchat_ts").css('display','inline');
					$("#cometchat_tabcontenttext_"+id).scrollTop(50000);
				} else {
					$("#cometchat_user_"+id+"_popup .cometchat_ts_date").css('display','none');
					$("#cometchat_user_"+id+"_popup .cometchat_ts").css('display','none');					
				}
			}

        };
    })();
 
})(jqcc);