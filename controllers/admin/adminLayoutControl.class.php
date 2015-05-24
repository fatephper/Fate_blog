<?php

    class adminLayoutControl extends IControl{
        
            public function init(){
                $this->layout = 'admin';
                $menu = array(
                    'menu-admin'=>array('admin'),
                    'menu-article'=>array('article','category','tag'),
                    'menu-media'=>array()
                );
                $this->setVal('menu',json_encode($menu));
            }
        
    }

?>