<?php
    /**
     * @brief 文章控制器
     **/
    class articleControl extends adminBaseControl {
                                    
            /*
             * @brief 列表-文章
             */
            public function index(){

                 $page = isset($_GET['page'])?$_GET['page']:1;
                 $pageSize = 20;
                 $where = "1=1";
                 //文章状态数组 
                 $articleStatus = array('1'=>'已发布','2'=>'回收站中');
                 //目录树
                 $categoryModel = $this->model('category','admin');
                 $categoryData = $categoryModel->getAll();
                 $treeData = $categoryModel->getTree($categoryData['category']);
                 //时间树
                 $timeData = array();
                 $timeArr = $this->model->getTime();
                 foreach($timeArr as $time){
                      $timeData[$time['year'].'-'.$time['month']] = $time['year'].'年'.$time['month'].'月'; 
                 }
                 //文章统计
                 $countData = $this->model->getNumberByStatus();
                 //查询条件 
                 if(!empty($_POST['post_date'])){
                     $where.=" AND post.post_date like '".$_POST['post_date']."%'";
                 }            
                 if(!empty($_POST['term_id'])){
                     $this->model('category')->getChildren($_POST['term_id'],$term_taxonomy_arr);
                     $where.=" AND relation.term_taxonomy_id in (".implode(',',$term_taxonomy_arr).")";
                 }
                 if(!empty($_GET['status'])){
                     $where.=" AND post.post_status='".$_GET['status']."'";
                 }
                 //文章列表
                 $articleData = $this->model->fields('post.*,relation.term_taxonomy_id')->join(' as post LEFT JOIN blog_term_relationships as relation ON post.ID = relation.object_id')->where($where)->group("post.ID")->limit(($page-1)*$pageSize,$pageSize)->order('post_date desc')->fetchAll();
                 
                $finalData = array();
              
                foreach($articleData as $article){
                    $temp = $this->model('user')->getInfoById($article['post_author'],'ID,user_nicename');
                    $article['post_author_id'] = $article['post_author'];
                    $article['post_author'] = $temp['user_nicename'];
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
                             'treeData'=>$treeData,
                             'countData'=>$countData,
                             'articleStatus'=>$articleStatus
                        );
                
                $this->render($data);
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
                    if(!$this->model->add($insertData)){
                        echo '插入失败';
                    }
                }
                $this->render('','admin/article/edit');
                
            }
            
            /*
             * @brief 编辑-文章
             */
            public function edit() {

                $this->render();
            }
            
            /**
             * @brief 回收-文章
             */
            public function recycle(){
                
                $where = '';
                if((($_POST['operation']!=-1)||($_POST['operation2']!=-1)) && !empty($_POST['article'])){
                        $where = "ID IN (".implode(',',$_POST['article']).")";
                }else if(!empty($_GET['id'])){
                        $where = "ID=".$_GET['id'];
                }
                if(!empty($where))
                    $this->model->update(array('post_status'=>'trash'),$where);
                
                $this->redirect('/admin/article');
            }
            
            /**
             * @brief 还原-文章
             */
            public function reduction(){
                
                $where = '';
                
                if((($_POST['operation']!=-1)||($_POST['operation2']!=-1)) && !empty($_POST['article'])){
                        $where = "ID IN (".implode(',',$_POST['article']).")";
                }else if(!empty($_GET['id'])){
                        $where = "ID=".$_GET['id'];
                }
                
                if(!empty($where))
                    $this->model->update(array('post_status'=>'publish'),$where);

                 $this->redirect('/admin/article');
            }
            
            /**
             * @brief 删除-文章
             */
            public function delete(){
                
                $where = '';
                
                if((($_POST['operation']!=-1)||($_POST['operation2']!=-1)) && !empty($_POST['article'])){
                        $where = "ID IN (".implode(',',$_POST['article']).")";
                }else if(!empty($_GET['id'])){
                        $where = "ID=".$_GET['id'];
                }
                
                if(!empty($where))
                    $this->model->delete($where);
                
                $this->redirect('/admin/article');
            }
                        
     }

?>