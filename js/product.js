$(document).ready(function () {

  
    function fetch_categories() {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '../actions/fetch_category_action.php',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    resolve(response.data);
                },
                error: function (xhr) {
                    reject(xhr.responseText);
                }
            });
        });
    }

    function loadCategories() {
        const categorySelect = $('#category_id');
        categorySelect.empty().append('<option value="">-- Select Category --</option>');
        fetch_categories().then((categoryList) => {
            categoryList.map((cat) => {
                categorySelect.append(`<option value="${cat.cat_id}">${cat.cat_name}</option>`);
            });
        });
    }

    function fetchBrandsByCategory(cat_id) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '../actions/fetch_brand_by_category_action.php?cat_id=' + cat_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    resolve(response.data);
                },
                error: function (xhr) {
                    reject(xhr.responseText);
                }
            });
        });
    }

    function buildBrandSelect(cat_id) {
        const brandSelect = $('#brand_id');
        brandSelect.empty().append('<option value="">-- Select Brand --</option>');
        fetchBrandsByCategory(cat_id).then((brandList) => {
            brandList.map((brand) => {
                brandSelect.append(`<option value="${brand.brand_id}">${brand.brand_name}</option>`);
            });
        });
    }

    function loadBrands() {
        const categorySelect = $('#category_id');
        categorySelect.on("change", function (event) {
            const category = event.target.value;
            buildBrandSelect(category);
        });
    }

    function loadProducts() {
        $.ajax({
            url: '../actions/fetch_product_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (productsList) {
                const products = productsList.data;
                const tbody = $('#product_table tbody');
                tbody.empty();
                if (products.length === 0) {
                    tbody.append('<tr><td colspan="7">No products found.</td></tr>');
                    return;
                }

                products.forEach(p => {
                    tbody.append(`
            <tr>
              <td>${p.product_id}</td>
              <td><img src="../${p.image_url}" alt="${p.product_title}" width="60"></td>
              <td>${p.product_title}</td>
              <td>${p.product_price}</td>
              <td>${p.cat_name}</td>
              <td>${p.brand_name}</td>
              <td>
                <button class="edit-btn" data-id="${p.product_id}">Edit</button>
                <button class="delete-btn" data-id="${p.product_id}">Delete</button>
              </td>
            </tr>
          `);
                });
            }
        });
    }

   
    $('#product_form').on('submit', function (e) {
        e.preventDefault();

        const fileInput = $('#product_image')[0];
        if (fileInput.files.length === 0) {
            Swal.fire('Image Required', 'Please upload a product image before saving.', 'warning');
            return;
        }

        const actionUrl = $('#product_id').val()
            ? '../actions/update_product_action.php'
            : '../actions/add_product_action.php';

        const formData = $(this).serialize();

        
        $.ajax({
            url: actionUrl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const productId = response.product_id || $('#product_id').val();

                    
                    const imageData = new FormData();
                    imageData.append('product_id', productId);
                    imageData.append('product_image', fileInput.files[0]);

                    $.ajax({
                        url: '../actions/upload_product_image_action.php',
                        type: 'POST',
                        data: imageData,
                        processData: false,
                        contentType: false,
                        dataType: 'json',
                        success: function (imgResponse) {
                            if (imgResponse.status === 'success') {
                                Swal.fire('Success', 'Product and image saved successfully!', 'success');
                                $('#product_form')[0].reset();
                                $('#upload_status').empty();
                                $('#product_id').val('');
                                loadProducts();
                            } else {
                                Swal.fire('Error', imgResponse.message, 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error', 'Image upload failed.', 'error');
                        }
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function () {
                Swal.fire('Error', 'Could not save product.', 'error');
            }
        });
    });

 
    $(document).on('click', '.edit-btn', function () {
        const product_id = $(this).data('id');
        $.ajax({
            url: '../actions/fetch_product_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (products) {
                const product = products.data.find(p => p.product_id == product_id);
                if (product) {
                    $('#form_title').text('Edit Product');
                    $('#product_id').val(product.product_id);
                    $('#product_title').val(product.product_title);
                    $('#product_price').val(product.product_price);
                    $('#product_desc').val(product.product_desc);
                    $('#product_keywords').val(product.product_keywords);
                    $('#category_id').val(product.cat_id);
                    $('#product_image_path').val(product.image_url);
                    $('#upload_status').html(`<img src="../${product.image_url}" width="60">`);

                    buildBrandSelect(product.cat_id);
                    fetchBrandsByCategory(product.cat_id).then((brandList) => {
                        const brandSelect = $('#brand_id');
                        brandSelect.empty().append('<option value="">-- Select Brand --</option>');
                        brandList.forEach((brand) => {
                            brandSelect.append(`<option value="${brand.brand_id}">${brand.brand_name}</option>`);
                        });
                        brandSelect.val(product.brand_id);
                    });
                }
            }
        });
    });


    $(document).on('click', '.delete-btn', function () {
        const product_id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the product.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../actions/delete_product_action.php',
                    type: 'POST',
                    data: { product_id },
                    success: function (response) {
                        Swal.fire('Deleted!', response, 'success');
                        loadProducts();
                    }
                });
            }
        });
    });


    loadCategories();
    loadBrands();
    loadProducts();
});
