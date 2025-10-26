$(document).ready(function () {
    add_brand();
    update_brand();
    fetch_brands();
    populate_categories();
    build_brand_table();

});

function populate_categories() {
    const categorySelect = $('#category_id');
    categorySelect.empty().append('<option value="">-- Select Category --</option>');
    fetch_categories().then((categoryList) => {
        categoryList.map((cat) => {
            categorySelect.append(`<option value="${cat.cat_id}">${cat.cat_name}</option>`);
        })
    })

}

function fetch_brands() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../actions/fetch_brand_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                resolve(response.data);
            },
            error: function (xhr) {
                reject(xhr.responseText);
            }
        });
    })
}

async function build_brand_table() {
    let tbody = $("#brand_table tbody");
    tbody.empty();

    const categories = await fetch_categories();
    const brands = await fetch_brands();

    if (brands.length === 0) {
        tbody.append("<tr><td colspan='3'>No Brands found</td></tr>");
    } else {
        brands.forEach(brand => {


            let options = categories.map(cat =>
                `<option value="${cat.cat_id}" ${cat.cat_id === brand.cat_id ? "selected" : ""}>${cat.cat_name}</option>`
            ).join("");

            let row = `
                            <tr>
                                <td>${brand.brand_id}</td>
                                <td>
                                    <form id="updateBrandForm" >
                                        <input type="hidden" name="brand_id" id="brand_id" value="${brand.brand_id}">
                                        <input type="text" name="brand_name" id="edit_brand_name" value="${brand.brand_name}" required>
                                        <select name="category_id">
                                            ${options}
                                        </select>
                                        <button type="submit">Update</button>
                             
                                     </form>
                                </td>
                                <td>
                                    <a onclick="delete_brand(${brand.brand_id})" class="delete-link" data-id="${brand.brand_id}">Delete</a>
                                </td>
                            </tr>
                        `;
            tbody.append(row);
        });
    }
}

function delete_brand(brand_id) {
    Swal.fire({
        title: 'Are you sure you want to delete this brand',
        icon: 'info',
        confirmButtonText: 'Delete',
        showCancelButton: true

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../actions/delete_brand_action.php?brand_id=' + brand_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then((_) => {
                            document.location.reload()
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message,
                        });
                    }
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred! Please try again later.',
                    });
                }
            });
        }
    })
}
function add_brand() {
    $('#brand_form').submit(function (e) {
        e.preventDefault();


        brand_name = $('#brand_name').val();
        category_id = $('#category_id').val();

        if (brand_name == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });

            return;
        }
        $.ajax({
            url: '../actions/add_brand_action.php',
            type: 'POST',
            data: {
                brand_name: brand_name,
                category_id: category_id
            },
            success: function (response) {
                if (response.status === 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        build_brand_table();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function (response) {
                console.log(response)
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.',
                });
            }
        });
    });
}

function update_brand() {
    $(document).on("submit", "#updateBrandForm", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: '../actions/update_brand_action.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: response.message,
                    }).then(() => {
                        build_brand_table();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: response.message,
                    });
                }
            },
            error: function (xhr) {
                console.log(xhr.responseText);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'An error occurred! Please try again later.',
                });
            }
        });
    });

}


