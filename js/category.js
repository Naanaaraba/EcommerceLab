$(document).ready(function () {
    add_category();
    update_category();
    build_category_table();
});

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
    })
}

function build_category_table() {
    let tbody = $("#cat_table tbody");
    tbody.empty();

    fetch_categories().then((categories) => {
        if (categories instanceof Array) {
            if (categories.length === 0) {
                tbody.append("<tr><td colspan='3'>No categories found</td></tr>");
            } else {
                categories.forEach(cat => {
                    let row = `
                            <tr>
                                <td>${cat.cat_id}</td>
                                <td>
                                    <form id="updateCategoryForm" >
                                        <input type="hidden" name="cat_id" id="cat_id" value="${cat.cat_id}">
                                        <input type="text" name="cat_name" id="edit_cat_name" value="${cat.cat_name}" required>
                                        <button type="submit">Update</button>
                                    </form>
                                </td>
                                <td>
                                    <a onclick="delete_category(${cat.cat_id})" class="delete-link" data-id="${cat.cat_id}">Delete</a>
                                </td>
                            </tr>
                        `;
                    tbody.append(row);
                });
            }
        } else {
            return '<tr>An error occurred while fetching the categories</tr>';
        }
    })
}

function delete_category(cat_id) {
    Swal.fire({
        title: 'Are you sure you want to delete this category',
        icon: 'info',
        confirmButtonText: 'Delete',
        showCancelButton: true

    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../actions/delete_category_action.php?cat_id=' + cat_id,
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
function add_category() {
    $('#category_form').submit(function (e) {
        e.preventDefault();


        cat_name = $('#cat_name').val();

        if (cat_name == '') {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please fill in all fields!',
            });

            return;
        }
        $.ajax({
            url: '../actions/add_category_action.php',
            type: 'POST',
            data: {
                cat_name: cat_name
            },
            success: function (response) {
                if (response.status === 'success') {

                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then((result) => {
                        build_category_table()
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

function update_category() {

    $(document).on("submit", "#updateCategoryForm", function (e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: '../actions/update_category_action.php',
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
                        fetch_categories();
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