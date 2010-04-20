
/*
 * CometChat - File Transfer Plugin
 * Copyright (c) 2009 Inscripts - support@cometchat.com | http://www.cometchat.com | http://www.inscripts.com
*/

(function($){   
  
	$.ccfiletransfer = (function () {

		var title = 'Send a file';

        return {

			getTitle: function() {
				return title;	
			},

			init: function (id) {
				baseUrl = $.cometchat.getBaseUrl();
				window.open (baseUrl+'plugins/filetransfer/index.php?id='+id, 'filetransfer',"status=0,toolbar=0,menubar=0,directories=0,resizable=0,location=0,status=0,scrollbars=0, width=400,height=170"); 
			}

        };
    })();
 
})(jqcc);