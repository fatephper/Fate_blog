<?php

    class settingControl extends adminLayoutControl {
                                        
                public function index(){
                    
                     $this->render('admin/setting/index');
                }
                
                public function write(){
                    
                    $this->render('admin/setting/write');
                }
                
                public function read(){
                    
                    $this->render('admin/setting/read');
                }
                
                public function discussion(){
                    
                    $this->render('admin/setting/discussion');
                }
                
                public function media(){
                    
                    $this->render('admin/setting/media');
                }
                
                public function url(){
                    
                    $this->render('admin/setting/url');
                }
    }

?>