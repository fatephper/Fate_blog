<?php
    /*
     * @brief 分类模型 
     */

    class categoryModel extends IModel{
        
        public  $categoryTree = array();
        
        public function init(){
                $this->table = 'categories';
        }
        
        public function getInfoById($id){
            
            $sql  = $this->fields('*')->where('id='.$id)->sql();
            return  $this->fetchOne($sql);
        }
                
        public function getAll($where='1=1'){
            
            $sql = $this->fields('*')->where($where)->order('id DESC')->sql();
            
            $data = $this->fetchAll($sql);
                        
            $categoryFinalData = array();
            $tagFinalData = array();
            
            foreach($data as $category){
                if($category['category_type']==1){
                    $categoryFinalData[$category['id']] = $category;
                }
                if($category['category_type']==2){
                    $tagFinalData[$category['id']] = $category;
                }
            }
            
            return array('all'=>$data,'tag'=>$tagFinalData,'category'=>$categoryFinalData);
        }
               
        public function getTree($data=array(),$level=0){
            
                $data = empty($data)?$this->getAll():$data;

                if(!empty($data['all'])){

                    $temp = array();

                    if(empty($this->categoryTree)){
                        foreach($data as $k=>$category){
                            if($category['parent_id'] == 0){
                                $category ['level'] = $level;
                                $this->categoryTree[] = $category;
                                unset($data[$k]);
                            }
                        }
                        $this->getTree($data,1);
                    }else{

                        foreach($this->categoryTree as $v){

                            $temp[] = $v;
                            foreach($data as $k =>$vv){
                                if($v['id']==$vv['parent_id']){
                                    $vv['level'] = $level;
                                    $temp[] = $vv;
                                    unset($data[$k]);
                                }
                            }
                        }

                        $this->categoryTree = $temp;

                        if(!empty($data))
                            $this->getTree($data,$level+1);
                    }
                }
                
                return $this->categoryTree;
        }
                        
        public function edit($condition,$data){

                $term = $data['term'];
                $termTaxonomy = $data['termTaxonomy'];

                if($this->update('blog_terms',$term,$condition)){
                    if($this->update('blog_term_taxonomy',$termTaxonomy,$condition))
                            return true;
                }
                
                return false;
        }
        
        public function del($id){
            
            $info = $this->getInfoById($id);
            $term_taxonomy_id = $info['term_taxonomy_id'];
            $this->delete('blog_terms','term_id='.$id);
            $this->delete('blog_term_taxonomy','term_id='.$id);
            $this->delete('blog_term_relationships','term_taxonomy_id='.$term_taxonomy_id);
        }
        
        public function getChildren($term_id,&$result_arr){
            
            if(empty($result_arr)){
                $term_taxonomy = $this->fields('term_taxonomy_id')->where('term_id='.$term_id)->fetchOne();
                $result_arr[] = $term_taxonomy['term_taxonomy_id'];
            }
            
            $temp = $this->fields("term_id,term_taxonomy_id")->where("parent=".$term_id)->fetchAll();
            
            if(!empty($temp)){
                foreach($temp as $v){
                    $result_arr[] = $v['term_taxonomy_id'];
                    $this->getChildren($v['term_id'],$result_arr);
                }
            }
        }
        
    }

?>