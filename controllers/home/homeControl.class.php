<?php
        /*
         * @brief 前端控制器
         */
        class homeControl extends homeBaseControl{
            
                /**
                 * @brief 首页-列表页
                 */
                public function index(){
                                       
                    $categoryModel = $this->model('category','admin');
                    $categoryData = $categoryModel->getAll();
                    $articleModel = $this->model('article','admin');
                    $articleAll  = $articleModel->fields('post.*,year(post.post_date) as year,month(post.post_date) as month,day(post.post_date) as day,relation.term_taxonomy_id')->join(' as post LEFT JOIN blog_term_relationships as relation ON post.ID = relation.object_id')->where("post_type='post'")->order('post_date desc')->getAll();
                    
                    $finalData = array();
              
                    foreach($articleAll as $article){

                        $finalData[$article['ID']]['post'] = $article;

                        if(isset($categoryData['tag']['term_taxonomy_id'])){
                            $finalData[$article['ID']]['tag'][] = $categoryData['tag']['term_taxonomy_id'];
                        }

                        if(isset($categoryData['tag']['term_taxonomy_id'])){
                            $finalData[$article['ID']]['cat'] = $categoryData['tag']['term_taxonomy_id'];
                        }
                    }
                    $data = array(
                        'articleAll'=>$finalData
                    );
                    
                    $this->render($data);
                }
                
                /**
                 * @brief 详情页
                 */
                public function detail(){
                    
                    $id = $_GET['id'];
                    $articleModel = $this->model('article','admin');
                    $info = $articleModel->getInfoById($id);
                    $data = array(
                          'article'=>$info
                    );
                    $this->render($data);
                }

        }


?>