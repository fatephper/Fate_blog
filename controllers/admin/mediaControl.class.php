<?php

    class mediaControl extends adminBaseControl{
        
            public function index(){
                
                $this->render('admin/media/index');
            }
            
            public function add(){
                
                $this->render('admin/media/add');
            }
    }


?>