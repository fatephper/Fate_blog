<?php

    class homeBaseControl extends IControl {

            public function init(){
                
                    $articleModel = $this->model('article','admin');
                    $categoryModel = $this->model('category','admin');
                    
                    $articleRandom = $articleModel->getRandom();
                    $articleArchive = $articleModel->getTime(); 
                    $articleTags =  $categoryModel->getAll('tt.taxonomy="post_tag"');
                    
                    $this->setVal('articleRandom',$articleRandom);
                    $this->setVal('articleArchive',$articleArchive);
                    $this->setVal('articleTags',$articleTags['all']);
            }
    }

?>