<?php
    /*
     * @brief 分类控制器
     */
    class tagControl extends adminLayoutControl {
        
        /**
         * @brief 首页-标签
         */
        public function index(){
            
            $categoryModel = $this->model('category','admin');
            $tagData = $categoryModel->getAll('tt.taxonomy="post_tag"');
            $data = array(
                  'tagData'=>$tagData,
                  'total'=>count($tagData)
            );
            
            $this->render($data);
        }
        
        /**
         * @brief 编辑-标签
         */
        public function edit(){
    
            $cid = $_GET['id'];
            $categoryModel = $this->model('category','admin');
            
            if(isset($_POST['submit'])){

                 $term = array('name'=>$_POST['name'],'slug'=>$_POST['slug']);
                 $termTaxonomy = array('description'=>$_POST['description']);
                 $categoryModel->edit('term_id='.$cid,array('term'=>$term,'termTaxonomy'=>$termTaxonomy));
            }
                
            $infoData = $categoryModel->getInfoById($cid);
            $data = array(
                 'tag'=>$infoData,
            );
            
            $this->render($data);
        }
        
        /**
         * @brief 添加-标签
         */
        public function add(){
              
            $termData = array(
                 'name'=>$_POST['tag-name'],
                 'slug'=>$_POST['slug']
            );
            
            $termTaxonomy = array(
                 'description' => $_POST['description'],
                 'taxonomy'=>$_POST['taxonomy']
            );
            
            $flag = $this->model('category','admin')->add(array('term'=>$termData,'termTaxonomy'=>$termTaxonomy));
            if(!$flag)
                die('插入失败');
            header('Location:/admin/tag');
            
        }
        
        /*
         * @brief 删除-标签
         */
        public function del(){
            
            $cid = $_GET['id'];
            $this->model('category','admin')->del($cid); 
            header('Location:/admin/tag');
        }

        
    }


?>