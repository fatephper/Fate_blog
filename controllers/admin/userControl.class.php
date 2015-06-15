<?php
        /**
         * @brief 后台用户控制器
         */
        class userControl extends adminBaseControl{
            
                public function init(){
                    
                    parent::init();
                }
            
                public function login(){
                    
                    if(!empty($_POST)){
                        
                        if(empty($_POST['uname'])){
                            $message = '用户名不能为空';
                        }
                        if(empty($_POST['pwd'])){
                            $message = '密码不能为空';
                        }

                        $userData = $this->model()->where("user_name='".$_POST['uname']."' AND user_pwd='".MD5($_POST['pwd'])."'")->fetchOne();          
                        if(!empty($userData)){
                            Fate::app()->cookie->set('uid',$userData['id']);
                            $this->redirect('/admin/admin');
                        }
                        
                    }
                    
                    $this->render('','',false);
                }
                
                public function logout(){
                    
                    Fate::app()->cookie->set('uid',0);
                    $this->redirect('/admin/user/login');
                }
                
                public function edit(){
                    
                }
                
                public function delete(){
                    
                }
                
                public function cgpwd(){
                    
                }
            
        }


?>