<?php
    /**
     * @brief 后台用户模型 
     */
    class userModel extends IModel{
        
          public function init(){
              $this->table="users";
          }
          
          public function getInfoById($uid,$fields){
              
              return $this->fields($fields)->where("ID=".$uid)->fetchOne();
          }
          
    }

?>