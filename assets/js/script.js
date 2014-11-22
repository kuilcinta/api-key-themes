/*
 * Addons Interactive handling
 * Versi 1.0
 * Author: Ofan
 */

jQuery(document).ready(function(){
    
    jQuery('body').on('keyup','textarea.getCaret',function (event) {
        if (event.keyCode == 13 && event.shiftKey) {
            var content = this.value;
            var caret = getCaret(this);
            this.value = content.substring(0,caret)+"\n"+content.substring(carent,content.length-1);
            event.stopPropagation();  
        }
        else if(event.keyCode == 13) {
            jQuery(this).closest('form').submit();
            //alert(jQuery(this).closest('form').attr('action'));
        }
    });

    jQuery('body').on('submit', 'form#form--login', function(e){
        e.preventDefault();

        var thisNode = jQuery(this);
        var act = domain+'/ajax.php';
        var dataset = {cl:'Users',fn:'login',err:1,prm:thisNode.serializeArray()};

        jQuery.getJSON(act,dataset).done(function(r){

            if(r.status == 200){
                console.log(r);
                //thisNode.prepend(r.data);
                window.location = domain+'/users?dashboard';
            }
            else{
                console.log(r);
                if(r.status==304){
                    if(thisNode.find('input[type=text]').val().length < 1){
                        thisNode.prepend(r.data).find('input[type=text]').focus();
                    }
                    else if(thisNode.find('input[type=password]').val().length < 1){
                        thisNode.prepend(r.data).find('input[type=password]').focus();
                    }
                    else{
                        thisNode.prepend(r.data);
                    }
                }
                else{
                    thisNode.prepend(r.data).find('input[type=text], input[type=password]').val('');
                }

                setTimeout(function(){ jQuery('.alert_login.clear_timeout').remove() }, 2000); 
            }

        });
        
        return false;
    });

});