function cmsSubmit(formulir,fungsi){
	
    var url;
    url = jQuery('#'+formulir).attr("action");
        
    jQuery('#'+formulir).form('submit',{
    	url			: url,
    	onSubmit	: function(){
    		return $(this).form('validate');    		
    	},
    	success		:function(data){    		
    		if (fungsi == undefined ){
    			if (data == "1"){
    				$.messager.alert('Sukses','Data Sudah Disimpan ');
    				//echo "1";
    			}else{
    				
    				$.messager.show({
    					title	: "Error",
    					msg		: data,
    					height	: 500,
    					width	: 500
    				});
    			}
    		}else{
    			fungsi(data);
    		}
    	},
    	error		:function(data){
    		if (fungsi == undefined ){
    			$.messager.alert('Error',data);
    		}else{
    			fungsi(data);
    		}
    	}
    });
}

/**
 * Set active main menu
 * hanya berlaku untuk matagaruda saja
 **/
$(function(){

    var url 		= window.location.pathname,
    
    	/* create regexp to match current url pathname 
    	 * and remove trailing slash if present 
    	 * as it could collide with the link in navigation 
    	 * in case trailing slash wasn't present there */
        urlRegExp 	= new RegExp(url.replace(/\/$/,'') + "$");
    
        // now grab every link from the navigation
        $('#mg-main-menu > li').each(function(){
        	var anak		= $(this).children('ul.dropdown-menu');
        	var hasChild 	= anak.size();        	        	
        	
        	// Jika mempunyai child maka operasi berikut yang dijalankan
        	if(hasChild == 1) {
        		var anchor = anak;
            	var anak2	= anak.children().children();
            	anak2.each(function(){            		
            		
            		if(urlRegExp.test(this.href.replace(/\/$/,''))){
            			
            			// Ambil parent ketas tiga kali
            			var atas	= $(this).parent().parent().parent()
            			$(atas).addClass('active');
                         
                    } 
            	});
        		
        	} 
        	// Jika tidak mempunyai child maka melakukan operasi berikut
        	else {
        		var anchor = $(this).children('a');
        		
            	var href = anchor.attr('href');        	
            	
                // and test its normalized href against the url pathname regexp        	
                if(urlRegExp.test(href.replace(/\/$/,''))){                	
                    $(this).addClass('active');
                    
                } 
        	}
        	
        	
        	       	
        	
        });

});