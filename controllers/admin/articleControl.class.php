<?php
    /**
     * @brief 文章控制器
     **/
    class articleControl extends adminLayoutControl {
                                    
            /*
             * @brief 列表-文章
             */
            public function index(){
                 
                 $page = isset($_GET['page'])?$_GET['page']:1;
                 $pageSize = 20;
                 $where = "post_type='post'";
                 
                 $categoryModel = $this->model('category','admin');
                 $categoryData = $categoryModel->getAll();

                 $treeData = $categoryModel->getTree($categoryData['category']);
                 
                 $timeData = array();
                 $timeArr = $this->model->getTime();
                 foreach($timeArr as $time){
                      $timeData[$time['year'].$time['month']] = $time['year'].'年'.$time['month'].'月'; 
                 }
                 
                 $articleData = $this->model->fields('post.*,relation.term_taxonomy_id')->join(' as post LEFT JOIN blog_term_relationships as relation ON post.ID = relation.object_id')->where($where)->limit(($page-1)*$pageSize,$pageSize)->order('post_date desc')->getAll();

                $finalData = array();
              
                foreach($articleData as $article){

                    $finalData[$article['ID']]['post'] = $article;
                    
                    if(isset($categoryData['tag'][$article['term_taxonomy_id']])){
                        $finalData[$article['ID']]['tag'][] = $categoryData['tag'][$article['term_taxonomy_id']];
                    }
                    
                    if(isset($categoryData['category'][$article['term_taxonomy_id']])){
                        $finalData[$article['ID']]['cat'] = $categoryData['category'][$article['term_taxonomy_id']];
                    }
                }
                
                $data = array(
                             'articleData'=>$finalData,
                             'timeData'=> $timeData,
                             'treeData'=>$treeData
                        );
                $this->render($data);
            }
            
            /*
             * @brief 编辑-文章
             */
            public function edit() {

                $this->render();
            }
                        
            /*
             * @brief 添加-文章
             */
            public function add(){
                
                if(isset($_POST['doAdd'])){
                    $term_id = empty($_POST['term_id'])?1:$_POST['term_id'];
                    $insertData = array(
                        'post_title'=>$_POST['post_title'],
                        'post_content'=>$_POST['post_content'],
                        'post_author'=>1,
                        'post_date'=>date('Y-m-d H:i:s',time()),
                        'post_status'=>'publish',
                        'term_id'=>$term_id
                    );  
                    if(!$this->model()->add($insertData)){
                        echo '插入失败';
                    }
                }
                $this->render('','admin/article/edit');
                
            }
            
            /**
             * @brief 回收-文章
             */
            public function recycle(){
                
                  $post_id = $_GET['id'];
                  
            }
            
            /*
             * @brief 删除-文章
             */
            public function del(){

            }
                        
     }

?>