<?php

    class mediaControl extends adminLayoutControl{
        
            public function index(){
                
                $this->render('admin/media/index');
            }
            
            public function add(){
                
                $this->render('admin/media/add');
            }
    }


?>