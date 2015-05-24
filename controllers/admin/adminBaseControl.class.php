<?php

    class adminBaseControl extends IControl{
            
            public $allowArr = array('admin:user:login');
        
            public function init(){
                
                  $mca = implode(array(Fate::app()->module,Fate::app()->control,Fate::app()->action),':');
                  if(!in_array($mca,$this->allowArr)){
                        $this->checkPower();
                  }
                  $this->rendLayout();
            }
            
            //检查权限
            public function checkPower(){
                
                 $uid = Fate::app()->cookie->get('uid');
                 if(empty($uid)){
                     $this->redirect('/admin/user/login');
                 }
            }
            
            //渲染后台布局文件
            public function rendLayout(){
                
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