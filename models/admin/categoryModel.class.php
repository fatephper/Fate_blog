<?php
    /*
     * @brief 分类模型 
     */

    class categoryModel extends IModel{
        
        public  $categoryTree = array();
        
        public function init(){
                $this->table = 'term_taxonomy';
        }
        
        public function getInfoById($id){
            
            $sql  = $this->fields('*')->join(' as tt INNER JOIN blog_terms  as t ON tt.term_id=t.term_id')->where('tt.term_id='.$id)->sql();
            $data = $this->fetchOne($sql);
            return $data;
        }
                
        public function getAll($where='1=1'){
            
            $sql = $this->fields('tt.*,t.*')->join(' as tt INNER JOIN blog_terms  as t ON tt.term_id=t.term_id')->where($where)->order('tt.term_id DESC')->sql();
            
            $data = $this->fetchAll($sql);
                        
            $categoryFinalData = array();
            $tagFinalData = array();
            
            foreach($data as $category){
                     if($category['taxonomy']=='category'){
                         $categoryFinalData[$category['term_taxonomy_id']] = $category;
                     }
                     if($category['taxonomy']=='post_tag'){
                         $tagFinalData[$category['term_taxonomy_id']] = $category;
                     }
            }
            
            return array('all'=>$data,'tag'=>$tagFinalData,'category'=>$categoryFinalData);
        }
               
        public function getTree($data=array(),$level=0){
            
                if(empty($data))
                    $data = $this->getAll();
                
                $temp = array();
                
                if(empty($this->categoryTree)){
                    foreach($data as $k=>$category){
                        if($category['parent'] == 0){
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
                            if($v['term_id']==$vv['parent']){
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
                
                return $this->categoryTree;
        }
                
        public function add($data){

                $termsData = $data['term'];
                $term_id = $this->insert('blog_terms',$termsData);
                $termTaxonomyData = $data['termTaxonomy'];
                $termTaxonomyData['term_id'] = $term_id;
                $flag = $this->insert('blog_term_taxonomy',$termTaxonomyData);
                
                return $flag;
            
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
        
    }

?>