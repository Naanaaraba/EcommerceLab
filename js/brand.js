$(document).ready(function () {
    console.log('Brand management page loaded');
    add_brand();
    populate_categories();
    loadBrandsByCategory();
});

function populate_categories() {
    console.log('Populating categories dropdown...');
    const categorySelect = $('#category_id');
    categorySelect.empty().append('<option value="">-- Select Category --</option>');
    
    fetch_categories().then((categoryList) => {
        console.log('Categories loaded:', categoryList);
        categoryList.forEach((cat) => {
            categorySelect.append(`<option value="${cat.cat_id}">${cat.cat_name}</option>`);
        });
    }).catch(error => {
        console.error('Error loading categories:', error);
        Swal.fire('Error', 'Failed to load categories', 'error');
    });
}

function fetch_categories() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../actions/fetch_category_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    resolve(response.data);
                } else {
                    reject(response.message);
                }
            },
            error: function (xhr, status, error) {
                reject('AJAX Error: ' + error);
            }
        });
    });
}

function fetch_brands() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: '../actions/fetch_brand_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                console.log('Brands response:', response);
                if (response.status === 'success') {
                    resolve(response.data);
                } else {
                    reject(response.message);
                }
            },
            error: function (xhr, status, error) {
                reject('AJAX Error: ' + error);
            }
        });
    });
}


function getCategoryIcon(categoryName) {
    if (!categoryName) return '🏷️';
    
    const lowerName = categoryName.toLowerCase();
    const icons = {
        'fashion': '👕', 'clothing': '👚',
        'electronics': '📱', 'beauty': '💄',
        'home and kitchen': '🏠', 
    };
    
    for (const [key, icon] of Object.entries(icons)) {
        if (lowerName.includes(key)) return icon;
    }
    return '🏷️';
}

async function loadBrandsByCategory() {
    //console.log('Loading brands by category...');
    try {
        const [categories, brands] = await Promise.all([
            fetch_categories(),
            fetch_brands()
        ]);
        
       // console.log('Data loaded - Categories:', categories, 'Brands:', brands);
        displayBrandsByCategory(categories, brands);
    } catch (error) {
        console.error('Error loading data:', error);
        Swal.fire({
            icon: 'error',
            title: 'Load Error',
            text: 'Failed to load brands and categories: ' + error,
        });
    }
}

function displayBrandsByCategory(categories, brands) {
    console.log('Displaying brands by category in table format...');
    const container = $('#category_groups');
    const noCategoriesState = $('#no-categories-state');
    
    // Clear container
    container.empty();
    
    if (!categories || categories.length === 0) {
        noCategoriesState.show();
        return;
    }
    
    noCategoriesState.hide();
    
   
    const brandsByCategory = {};
    brands.forEach(brand => {
        if (!brandsByCategory[brand.cat_id]) {
            brandsByCategory[brand.cat_id] = [];
        }
        brandsByCategory[brand.cat_id].push(brand);
    });
    
    console.log('Brands grouped by category:', brandsByCategory);
    
    categories.forEach(category => {
        const categoryBrands = brandsByCategory[category.cat_id] || [];
        
        const categoryGroup = $(`
          <div class="category-group">
            <div class="category-header">
              <h4 class="category-title">
                <span class="category-icon">${getCategoryIcon(category.cat_name)}</span>
                <span>${category.cat_name}</span>
                <span class="brands-count">${categoryBrands.length} brand${categoryBrands.length !== 1 ? 's' : ''}</span>
              </h4>
            </div>
            <div class="brands-table-container"></div>
          </div>
        `);
        
        const tableContainer = categoryGroup.find('.brands-table-container');
        
        if (categoryBrands.length === 0) {
            tableContainer.html(`
                <div class="empty-table">
                    <div class="icon">🏷️</div>
                    <p>No brands in this category yet</p>
                </div>
            `);
        } else {
            // Create table
            const table = $(`
                <table class="brands-table">
                    <thead>
                        <tr>
                            <th style="width: 80px;">ID</th>
                            <th>Brand Name</th>
                            <th style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            `);
            
            const tbody = table.find('tbody');
            
            categoryBrands.forEach(brand => {
                // Escape brand name for HTML
                const escapedBrandName = brand.brand_name.replace(/'/g, "&#39;").replace(/"/g, "&quot;");
                
                const row = $(`
                    <tr class="brand-row">
                        <td class="brand-id-cell">${brand.brand_id}</td>
                        <td class="brand-name-cell">${brand.brand_name}</td>
                        <td>
                            <div class="table-actions">
                                <button class="btn-edit btn-sm" onclick="openEditBrandModal(${brand.brand_id}, '${escapedBrandName}', ${brand.cat_id})">Edit</button>
                                <button class="btn-delete btn-sm" onclick="delete_brand(${brand.brand_id})">Delete</button>
                            </div>
                        </td>
                    </tr>
                `);
                tbody.append(row);
            });
            
            tableContainer.append(table);
        }
        
        container.append(categoryGroup);
    });
    
    
    if (brands.length === 0) {
        container.html(`
            <div class="no-categories-state">
                <div class="icon">🏷️</div>
                <h3>No Brands Found</h3>
                <p>Create your first brand to get started. Brands will be automatically grouped by their categories.</p>
            </div>
        `);
    }
}

function delete_brand(brand_id) {
    console.log('Deleting brand:', brand_id);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../actions/delete_brand_action.php?brand_id=' + brand_id,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    console.log('Delete response:', response);
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                        }).then(() => {
                            loadBrandsByCategory(); // Refresh the display
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to delete brand',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Delete error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the brand.',
                    });
                }
            });
        }
    });
}

function add_brand() {
    console.log('Setting up brand form submission...');
    $('#brand_form').submit(function (e) {
        e.preventDefault();

        const brand_name = $('#brand_name').val().trim();
        const category_id = $('#category_id').val();

        console.log('Form data:', { brand_name, category_id });

        
        if (brand_name === '') {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please enter a brand name!',
            });
            return;
        }

        if (category_id === '') {
            Swal.fire({
                icon: 'error',
                title: 'Missing Information',
                text: 'Please select a category!',
            });
            return;
        }

      
        const submitBtn = $('#brand_form button[type="submit"]');
        const originalText = submitBtn.text();
        submitBtn.prop('disabled', true).text('Creating...');

        $.ajax({
            url: '../actions/add_brand_action.php',
            type: 'POST',
            data: {
                brand_name: brand_name,
                category_id: category_id
            },
            dataType: 'json',
            success: function (response) {
                console.log('Add brand response:', response);
                submitBtn.prop('disabled', false).text(originalText);
                
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                    }).then(() => {
                        $('#brand_form')[0].reset();
                        loadBrandsByCategory();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'Failed to add brand',
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Add brand error:', error, xhr.responseText);
                submitBtn.prop('disabled', false).text(originalText);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while adding the brand. Please try again.',
                });
            }
        });
    });
}


function openEditBrandModal(brand_id, brand_name, cat_id) {
    console.log('Opening edit modal for brand:', { brand_id, brand_name, cat_id });
    
    const modalHtml = `
        <div class="modal fade" id="editBrandModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="background: var(--deep-navy); border: 1px solid rgba(232, 228, 217, 0.15);">
                    <div class="modal-header" style="border-bottom: 1px solid rgba(232, 228, 217, 0.1);">
                        <h5 class="modal-title" style="color: var(--stone); font-family: 'Space Grotesk', sans-serif;">Edit Brand</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editBrandForm">
                            <input type="hidden" name="brand_id" value="${brand_id}">
                            <div class="form-group">
                                <label class="form-label">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" value="${brand_name.replace(/'/g, "&#39;")}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="">-- Select Category --</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(232, 228, 217, 0.1);">
                        <button type="button" class="btn-primary" onclick="updateBrand()">Update Brand</button>
                        <button type="button" class="btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    $('#editBrandModal').remove();
    

    $('body').append(modalHtml);
    
    const modalElement = document.getElementById('editBrandModal');
    const modal = new bootstrap.Modal(modalElement);

    $(modalElement).on('shown.bs.modal', function () {
        const select = $(this).find('select[name="category_id"]');
        select.empty().append('<option value="">-- Select Category --</option>');
        
        fetch_categories().then((categoryList) => {
            categoryList.forEach((cat) => {
                select.append(`<option value="${cat.cat_id}" ${cat.cat_id == cat_id ? 'selected' : ''}>${cat.cat_name}</option>`);
            });
        }).catch(error => {
            console.error('Error loading categories for modal:', error);
        });
    });
    

    $(modalElement).on('hidden.bs.modal', function () {
        $(this).remove();
    });
    
    modal.show();
}

function updateBrand() {
    console.log('Updating brand...');
    const formData = $('#editBrandForm').serialize();
    
    const updateBtn = $('#editBrandModal .btn-primary');
    const originalText = updateBtn.text();
    updateBtn.prop('disabled', true).text('Updating...');
    
    $.ajax({
        url: '../actions/update_brand_action.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function (response) {
            console.log('Update response:', response);
            updateBtn.prop('disabled', false).text(originalText);
            
            if (response.status === 'success') {
                const modal = bootstrap.Modal.getInstance(document.getElementById('editBrandModal'));
                modal.hide();
                
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: response.message,
                }).then(() => {
                    loadBrandsByCategory();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message || 'Failed to update brand',
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('Update error:', error);
            updateBtn.prop('disabled', false).text(originalText);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the brand.',
            });
        }
    });
}


document.addEventListener('DOMContentLoaded', function() {
    const style = document.createElement('style');
    style.textContent = `
        .btn-secondary {
            background: transparent;
            border: 1px solid var(--sage);
            color: var(--sage);
            padding: 0.5rem 1rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: var(--sage);
            color: var(--deep-navy);
        }
        .modal-content {
            background: var(--deep-navy) !important;
            color: var(--stone) !important;
        }
        .modal-header, .modal-footer {
            border-color: rgba(232, 228, 217, 0.1) !important;
        }
    `;
    document.head.appendChild(style);
});