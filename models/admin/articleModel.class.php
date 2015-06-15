<?php 
    /**
     * @brief 文章模型 
     */
    class articleModel extends IModel {
        
            public function init(){
                  $this->table = 'posts';
            }
                        
            /**
             * @brief 返回文章归档时间
             * @return 
             */
            public function getTime(){
                    
                return  $this->fields('YEAR(post_date) as year,MONTH(post_date) as month')->where('post_type="post" GROUP BY year,month')->order('post_date DESC')->fetchAll();
            }
            
            /**
             * @brief 统计不同类型文章个数
             */
            public function getNumberByStatus(){
                  
                  $temp_arr = array();
                  $data = $this->fields('count(*) as number,post_status')->group('post_status')->fetchAll();
                  foreach($data as $v){
                      $k = $v['post_status'];
                      $temp_arr[$k] = $v['number'];
                  }
                  $temp_arr['all'] = array_sum($temp_arr);
                  return $temp_arr;
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
                
                return $this->fields('ID,YEAR(post_date) as year,MONTH(post_date) as month, DAY(post_date) as day,post_title')->where("post_type = 'post' AND (post_status = 'publish' OR post_status = 'future' OR post_status = 'draft' OR post_status = 'pending' OR post_status = 'private') ")->order('post_date DESC')->limit('5')->fetchAll();

            }
            
            /**
             * @brief 返回指定ID文章数据
             */
            public function getInfoById($id){
                 
                return $this->fields('a.ID,a.post_date,a.post_title,a.comment_count,a.post_content,year(post_date) as year,month(post_date) as month, day(post_date) as day,u.display_name,t.name')->join(' as a INNER JOIN blog_users as u ON a.post_author = u.ID INNER JOIN blog_term_relationships as tr ON a.ID=tr.object_id INNER JOIN blog_term_taxonomy as tt ON tr.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN blog_terms as t on tt.term_id= t.term_id')->where("a.ID={$id}")->fetchOne();

            }
            
            /**
             * @brief 添加文章
             */
            public function add($data){
                
               $termId = $data['term_id'];
               unset($data['term_id']);
               $objectId = $this->insert($data);
               if($objectId!==false){
                   if($this->insert('blog_term_relationships',array('object_id'=>$objectId,'term_taxonomy_id'=>$termId)))
                       return true;
               }
               return false;
            }
                        
    }


?>