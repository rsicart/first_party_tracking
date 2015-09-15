window._tracker = {
    // properties
    navId: [],
    url: 'http://tracker.local/event.php',
    // methods
	getParameterByName: function(key, target) {
		var values = [];
		if(!target){
			target = location.href;
		}

		key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
		var pattern = key + '=([^&#]+)';
		var o_reg = new RegExp(pattern,'ig');
		while (true) {
			var matches = o_reg.exec(target);
			if (matches && matches[1]) {
				values.push(matches[1]);
			} else {
				break;
			}
		}

		if(!values.length){
			 return null;   
		 }
		else{
		   return values.length == 1 ? values[0] : values;
		}
	},
    setCookie: function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    },
    getCookie: function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
        }
        return "";
    },
    setNavId: function() {
        // add all navIds to object's property as an array
        var existent = window._tracker.getCookie('navId');
        if (existent)
            window._tracker.navId.push(existent);
        var fromGet = window._tracker.getParameterByName('navId');
        if (fromGet && existent.indexOf(fromGet) < 0)
            window._tracker.navId.push(window._tracker.getParameterByName('navId'));
    },
    setNavIdInCookie: function() {
        var expDays = 2;
        var ids = window._tracker.navId.join();
        window._tracker.setCookie('navId', ids, expDays);
    },
    init: function() {
        window._tracker.setNavId();
        window._tracker.setNavIdInCookie();
    },
    trackEvent: function(type) {
        var allowed = ['impression', 'click', 'lead',];
        if (allowed.indexOf(type) < 0) {
            return;
        }
        var cb = Math.random().toString().substr(2);
        var url = window._tracker.url + '?type='+type+'&navId='+window._tracker.navId+'&cb='+cb;

        // create script elem
        var s = document.getElementsByTagName("script")[0];
		var script = document.createElement('script');
		script.setAttribute('type', 'text/javascript');
		script.setAttribute('src', url);
		s.parentNode.insertBefore(script, s);

        // create img elem
        //// tracks 2 events, dont know why!
		//var img = document.createElement('img');
		//img.width = img.height = 1;
		//img.style.setProperty("position", "absolute");
		//img.style.setProperty("left", "-9999px");
		//img.setAttribute("src", url);
		//document.body.appendChild(img);
    },
}

// run
window._tracker.init();
