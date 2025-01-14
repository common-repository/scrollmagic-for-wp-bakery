(function($) {
    'use strict';
    $(document).ready(function () {
        var a = "";
        $('.wpb-content-layouts li').each(function(){
            a += $(this).find('.vc_shortcode-link').attr('id')+",";
        })
        createCookie("allshortcode", a, "10"); 

        function createCookie(name, value, days) { 
            var expires; 
            
            if (days) { 
                var date = new Date(); 
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000)); 
                expires = "; expires=" + date.toGMTString(); 
            } 
            else { 
                expires = ""; 
            } 
            document.cookie = escape(name) + "=" +  
            escape(value) + expires + "; path=/"; 
        } 
    }); 
    
})( jQuery );