 <?php
    require_once '../classes/brand_class.php';

    function add_brand_ctr($brand_name, $cat_id)
    {
        $brand = new Brand();
        return $brand->addBrand($brand_name, $cat_id);
    }

    function fetch_brand_ctr()
    {
        $brand = new Brand();
        return $brand->fetchBrands();
    }

    function fetch_brands_by_category_ctr($cat_id)
    {
        $brand = new Brand();
        return $brand->fetchBrandsByCategory($cat_id);
    }

    function delete_brand_ctr($brand_id)
    {
        $brand =  new Brand();
        return $brand->deleteBrand($brand_id);
    }

    function update_brand_ctr($brand_id, $brand_name, $cat_id)
    {
        $brand =  new Brand();
        return $brand->updateBrand($brand_id, $brand_name, $cat_id);
    }
