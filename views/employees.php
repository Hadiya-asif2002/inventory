<div class="card">
    <h5 class="card-header">employees</h5>
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel2">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="employee-form">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter Name"
                                    value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" id="name" name="designation" class="form-control"
                                    placeholder="Enter designation" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="reports_to" class="form-label">Reports To</label>
                                <input type="text" id="name" name="reports_to" class="form-control"
                                    placeholder="Reports To" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="departmentid" class="form-label">Department Id</label>
                                <input type="text" id="departmentid" name="department_id" class="form-control"
                                    placeholder="Enter Department Id" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="tag" class="form-label">Tag</label>
                                <input type="text" id="tag" name="tag" class="form-control" placeholder="Enter Tag"
                                    value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col mb-3">
                                <label for="floor" class="form-label">Floor</label>
                                <input type="text" id="floor" floor="floor" name="floor" class="form-control"
                                    placeholder="Enter floor" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="anydesk_address" class="form-label">Anydesk Address</label>
                                <input type="text" id="anydesk_address" name="anydesk_address" class="form-control"
                                    placeholder="Enter Anydesk Address" value="" />
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


    <button class="btn btn-primary w-25" id="add-employee-btn" data-bs-toggle="modal"
        data-bs-target="#employeeModal">Add
        new employee</button>


    <div class="table-responsive text-nowrap">
        <table class="table" id="employee-table">
            <thead>

            </thead>
            <tbody id="tbody-employees">

            </tbody>
        </table>
    </div>
</div>

<script>


    $('tbody').on("click", "button.edit", function () {
        name = $('input[name="name"]')
        let inputName = $('#employee-form input[name="name"]')
        value = $(this).closest('tr').children()[1].innerText
        inputName.val(value);
        let id = $(this).closest('tr').children()[0].innerText
        form = $('#employee-form');
        form.append('<input type="number" class="form-control" readonly name="id" value="' + id + '">');
    })
    let emp_table = $('#employee-table tbody');
    $.ajax({
        url: 'https://localhost/inventory/employees',
        success: function (response) {
            if (response.status === 200) {

                employees = response.data;
                keyNames = Object.keys(employees[0]);
                thead = $('#employee-table thead');
                theadHtml = '<tr>'
                theadHtml += Object.entries(keyNames).map(([key, value]) => '<th>' + value + '</th>').join('')
                theadHtml += '</tr>'
                thead.html(theadHtml);
                html = ''

                employees.forEach(employee => {
                    html += '<tr scope="row">'
                    html += (Object.entries(employee)
                        .map(
                            ([key, value]) => '<td>' + value + '</td>')
                    ).join('')
                    html += '<td><button class="delete btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-id="' + employee.id + '">Delete</button></td>';
                    html += '<td><button class="edit btn btn-primary" data-bs-toggle="modal" data-bs-target="#employeeModal" data-id="' + employee.id + ' ">Edit</button></td>';

                    html += '</tr>';

                });
                emp_table.html(html);
            }

        }
    });

    $('#add-employee-btn').on("click", function () {
        $('#employee-form input[name="id"]').remove()
    });


    $('#employee-form').on("submit", function () {
        event.preventDefault();
        formData = $(this).serializeArray();

        $.ajax({
            url: 'https://localhost/inventory/employees',
            method: 'POST',
            data: formData,
            success: function (response) {
                console.log(response)
                location.reload();
            },
            error: function (error) {
                console.error(error);
            }
        })
    })

    function deleteEmployee(id) {
        url = 'https://localhost/inventory/employees/employee?id=' + id;
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
    // TODO: improve this code
    $('#employee-table tbody').on("click", "button.delete", function () {
        id = $(this).data('id');
        $('#deleteConfirmationModal button[name="confirm"]').on("click", function() {
            deleteEmployee(id);
        })
    })

</script>