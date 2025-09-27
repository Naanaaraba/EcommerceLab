 <?php
    require_once '../classes/category_class.php';

    function add_category_ctr($cat_name)
    {
        $category = new Category();
        return $category->addCategory($cat_name);
    }

    function fetch_category_ctr(){
        $category = new Category();
        return $category->fetchCategories();
    }

    function delete_category_ctr($cat_id){
        $category =  new Category();
        return $category->deleteCategory($cat_id);


    }
    function update_category_ctr($cat_id, $cat_name){
        $category =  new Category();
        return $category->updateCategory($cat_id, $cat_name);


    }
