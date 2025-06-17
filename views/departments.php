<div class="card">
    <h5 class="card-header">Departments</h5>
    <div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="department-form">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    placeholder="Enter Name" value=""/>
                            </div>
                        </div>
               


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        cancel
                    </button>
                    <button type="submit" name="action" value="" class="btn btn-primary">Save changes</button>
                </div>
                     </form>
            </div>
        </div>
    </div>

<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Are you sure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        cancel
                    </button>
                    <button type="submit" id="delete-deparatment" name="confirm" value="" class="btn btn-primary">Save changes</button>
                </div>
                     </form>
            </div>
        </div>
    </div>
    <button class="btn btn-primary w-25" id="add-department-btn" data-bs-toggle="modal" data-bs-target="#departmentModal">Add new Department</button>


    <div class="table-responsive text-nowrap">
        <table class="table" id="department-table">
            <thead>

            </thead>
            <tbody id="tbody-departments">
                <tr>
                    <td><button class="delete">click me</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<script>

  
    $('tbody').on("click", "button.edit", function () {
        name = $('input[name="name"]' )
        let inputName =$('#department-form input[name="name"]' )
        value = $(this).closest('tr').children()[1].innerText
        inputName.val(value);
        let id =  $(this).closest('tr').children()[0].innerText
        form = $('#department-form');
        form.append('<input type="number" class="form-control" readonly name="id" value="' + id + '">');
    })
    $.ajax({
        url: 'https://localhost/inventory/departments',
        success: function (response) {
            if (response.status === 200) {
                let table = $('#department-table tbody');
                html = ''
                employees = response.data;
                keyNames = Object.keys(employees[0]);
                thead = $('#department-table thead')
                theadHtml = '<tr>'
                theadHtml += Object.entries(keyNames).map(([key, value]) => '<th>' + value + '</th>').join('')
                theadHtml += '<th>Actions</th>';
                theadHtml += '</tr>'
                thead.html(theadHtml);
                employees.forEach(employee => {
                    html += '<tr scope="row">'
                    html += (Object.entries(employee)
                        .map(
                            ([key, value]) => '<td>' + value + '</td>')
                    ).join('')
                    html += '<td><button class="delete btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-id="' + employee.id + '">Delete</button></td>';
                    html += '<td><button class="edit btn btn-primary" data-bs-toggle="modal" data-bs-target="#departmentModal" data-id="' + employee.id + ' ">Edit</button></td>';

                    html += '</tr>';
                });
                table.html(html);
            }

        }
    });
    $('#department-form').on("submit", function () {
        event.preventDefault();
        formData = $(this).serializeArray();
        data = {}
        formData.forEach(function (item) {
            if (item.name === 'name' || item.name=='id') {
                data[item.name] =item.value
            }
        });
        $.ajax({
            url: 'https://localhost/inventory/departments',
            method: 'POST',
            data: data,
            success: function (response) {
                location.reload()
            },
            error: function (error) {
                console.error(error);
            }
        })
    })
    function deleteDepartment(id) {
        url = 'https://localhost/inventory/departments/department?id=' + id;
                $.ajax({
                    url: url,
                    method: 'DELETE',
                    success: function (response) {
                        
                        if (response.status === 200) {
                            location.reload();
                        }
                    },
         
                })
    }

    $('#department-table tbody').on("click", "button.delete", function () {
        id = $(this).data('id');
        $('#deleteConfirmationModal button[name="confirm"]').on("click", function() {
            deleteDepartment(id);
        })
    })


    $('#add-department-btn').on("click", function () {
        $('#department-form input[name="id"]').remove()
    });

</script>