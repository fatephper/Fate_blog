$(function(){

        var uri = '<{echo:Fate::app()->url->getUri()}>'
        var module = '<{echo:Fate::app()->control}>'; 
        var menu_bar = $('#adminmenu');
        var current_menu = $("#menu-"+module);
        var current_tag = current_menu.children('ul').children('li').children('a[href="'+uri+'"]');

        current_menu.toggleClass('wp-not-current-submenu wp-has-current-submenu');
        current_menu.children('a').toggleClass('wp-not-current-submenu wp-has-current-submenu');
        current_tag.addClass('current');
        current_tag.parent().addClass('current');

        menu_bar.children('li').hover(function(){
                $(this).addClass('opensub');
                $(this).children('ul').css('top',-1);
        },function(){
                $(this).removeClass('opensub');
                if(!$(this).hasClass('wp-has-current-submenu')){
                    $(this).children('ul').css('top','-1000em'); 
                }
        })
        
        function initLayout(){
            
            var hight = document.documentElement.clientHeight - $("#nav").outerHeight(true);   

            $('#adminmenuwrap').height(hight); 
            $('#wpwrap').height(hight);
            
        }
		
        initLayout();

        $(window).resize(function(){   
                        initLayout();   
        });

})