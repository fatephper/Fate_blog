<?php 
    /**
     * @brief 文章模型 
     */
    class articleModel extends IModel {
        
            public function init(){
                  $this->table = 'posts';
            }
            
            /**
             * @brief 返回所有文章
             * @return type
             */
            public function getAll(){
                
                $data = $this->fetchAll($this->sql());
                return $data;
            }
            
            /**
             * @brief 返回文章归档时间
             * @return type
             */
            public function getTime(){
                    
                  $sql = $this->fields('YEAR(post_date) as year,MONTH(post_date) as month')->where('post_type="post" GROUP BY year,month')->order('post_date DESC')->sql();
                  $data = $this->fetchAll($sql);
                  return $data;
            }
            
            /**
             * @brief 返回最近的文章
             * @return 
             */
            public function getRecent(){
                
            }
            
            /**
             * @brief 返回随机推荐文章
             */
            public function getRandom(){
                
                $sql = $this->fields('ID,YEAR(post_date) as year,MONTH(post_date) as month, DAY(post_date) as day,post_title')->where("post_type = 'post' AND (post_status = 'publish' OR post_status = 'future' OR post_status = 'draft' OR post_status = 'pending' OR post_status = 'private') ")->order('post_date DESC')->limit('5')->sql();
                $data = $this->fetchAll($sql);
                return $data;
            }
            
            /**
             * @brief 返回指定ID文章数据
             */
            public function getInfoById($id){
                 
                $sql = $this->fields('a.ID,a.post_date,a.post_title,a.comment_count,a.post_content,year(post_date) as year,month(post_date) as month, day(post_date) as day,u.display_name,t.name')->join(' as a INNER JOIN blog_users as u ON a.post_author = u.ID INNER JOIN blog_term_relationships as tr ON a.ID=tr.object_id INNER JOIN blog_term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN blog_terms as t on tt.term_id= t.term_id')->where("a.ID={$id}")->sql();
                 
                $data = $this->fetchOne($sql);
                return $data;
            }
            
            /**
             * @brief 添加文章
             */
            public function add($data){
                
               $termId = $data['term_id'];
               unset($data['term_id']);
               $objectId = $this->insert('blog_posts',$data);
               if($objectId!==false){
                   if($this->insert('blog_term_relationships',array('object_id'=>$objectId,'term_taxonomy_id'=>$termId)))
                       return true;
               }
               return false;
            }
            
            /**
             * @brief 修改文章
             */
            public function edit($condition,$editData){
                
                return $this->update('blog_posts',$editData,$condition);         
            }
            
            /**
             * @brief 删除文章
             */
            public function del(){
                
            }
            
    }


?>