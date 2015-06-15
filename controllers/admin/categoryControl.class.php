<?php
    /*
     * @brief 分类控制器
     */
    class categoryControl extends adminBaseControl {
        
        /**
         * @brief 首页-分类
         */
        public function index(){
            
            $all = $this->model()->getAll('category_type=1');
            $treeData = $this->model()->getTree($all['category']);
            $data = array(
                  'treeData'=>$treeData,
                  'total'=>count($all)
            );
            $this->render($data);
        }
        
        /**
         * @brief 编辑-分类
         */
        public function edit(){
    
            $cid = $_GET['id'];
            
            if(isset($_POST['submit'])){

                 $term = array('name'=>$_POST['name'],'slug'=>$_POST['slug']);
                 $termTaxonomy = array('parent'=>$_POST['parent'],'description'=>$_POST['description']);
                 $this->model()->edit('term_id='.$cid,array('term'=>$term,'termTaxonomy'=>$termTaxonomy));
                 
            }
                
            $infoData = $this->model()->getInfoById($cid);
            $treeData = $this->model()->getTree();
            $data = array(
                 'category'=>$infoData,
                 'tree'=>$treeData,
            );
            
            $this->render($data);
        }
        
        /**
         * @brief 添加-分类
         */
        public function add(){

            $flag = $this->model()->insert();
            if(!$flag)
                die('插入失败');
            $this->redirect('/admin/category');
        }
        
        /*
         * @brief 删除-分类
         */
        public function del(){
            
            $cid = $_GET['id'];
            $this->model()->del($cid); 
            header('Location:/admin/category');
        }

        
    }


?>