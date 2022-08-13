@extends('layouts.app')

@section('content')
@include('sweetalert::alert')

<div class="modal" id="AddEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Add Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="AddEmployeeForm" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <ul class="alert alert-warning d-none" id="save_errorList"></ul>
                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>

{{-- Edit Employee Modal --}}
<div class="modal" id="EditEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Edit Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="UpdateEmployeeForm" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="emp_id" id="emp_id">
                <ul class="alert alert-warning d-none" id="update_errorList"></ul>
                <div class="form-group mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Phone</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal" id="DeleteEmployeeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title">Delete Employee</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="AddEmployeeForm" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <h4>Are you sure to delete this data??</h4>
                <input type="hidden" id="delete_emp_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="delete_modal_btn btn btn-primary">Yes, Delete</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Laravel Ajax Image Crud - Employee Data
                        <a class="col-lg-3 mb-4" href="#" class="btn btn-primary btn-sm float-end" data-toggle="modal" data-target="#AddEmployeeModal">Add Employee</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        fetchEmployee();
        function fetchEmployee()
        {
            $.ajax({
                type: "GET",
                url: "/fetch-employee",
                dataType: "json",
                success: function (response) {
                    // console.log(response.employee);
                    $('tbody').html("");
                    $.each(response.employee, function (key, item) {
                        $('tbody').append('<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td><img src="uploads/employee/'+item.image+'" width="50px" height="50px" alt="image"></td>\
                                    <td><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></td>\
                                    <td><button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                                </tr>');
                    });
                }
            });
        }

        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();

            var emp_id = $(this).val();
            $('#DeleteEmployeeModal').modal('show');
            $('#delete_emp_id').val(emp_id);
        });

        $(document).on('click', '.delete_modal_btn', function (e) {
            e.preventDefault();

            var id = $('#delete_emp_id').val();
            $.ajax({
                type: "DELETE",
                url: "/delete-employee/"+id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 404)
                    {
                        alert(response.message);
                        $('#DeleteEmployeeModal').modal('hide');
                    }
                    else if(response.status == 200)
                    {
                        swal({
                            title: "DELETED!",
                            text: response.message,
                            icon: "warning",
                        });
                        $('#DeleteEmployeeModal').modal('hide');
                        fetchEmployee();
                    }
                }
            });
        });

        $(document).on('click', '.edit_btn', function (e) {
            e.preventDefault();

            var emp_id = $(this).val();
            // alert(emp_id);
            $('#EditEmployeeModal').modal('show');

            $.ajax({
                type: "GET",
                url: "/edit-employee/"+emp_id,
                success: function (response) {
                    if(response.status == 404)
                    {
                        swal({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                        });
                        $('#EditEmployeeModal').modal('hide');
                    }
                    else
                    {
                        $('#edit_name').val(response.employee.name);
                        $('#edit_phone').val(response.employee.phone);
                        $('#emp_id').val(emp_id);
                    }
                }
            });

        });

        $(document).on('submit', '#UpdateEmployeeForm', function (e) {
            e.preventDefault();

            var id = $('#emp_id').val();
            let editFormData = new FormData($('#UpdateEmployeeForm')[0]);

            $.ajax({
                type: "POST",
                url: "/update-employee/"+id,
                data: editFormData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.status == 400)
                    {
                        $('#update_errorList').html("");
                        $('#update_errorList').removeClass('d-none');
                        $.each(response.errors, function (key, err_value){
                            $('#update_errorList').append('<li>'+err_value+'</li>');
                        });
                    }
                    else if(response.status == 404)
                    {
                        alert(response.message);
                    }
                    else if(response.status == 200)
                    {
                        $('#update_errorList').html("");
                        $('#update_errorList').removeClass('d-none');

                        // $('#UpdateEmployeeForm').find('input').val('');
                        $('#EditEmployeeModal').modal('hide');
                        swal({
                            title: "UPDATED!",
                            text: response.message,
                            icon: "success",
                        });
                        fetchEmployee();
                    }
                }
            });
        });

        $(document).on('submit', '#AddEmployeeForm', function (e) {
            e.preventDefault();

            let formData = new FormData($('#AddEmployeeForm')[0]);

            $.ajax({
                type: "POST",
                url: "/employee",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    if(response.status == 400)
                    {
                        $('#save_errorList').html("");
                        $('#save_errorList').removeClass('d-none');
                        $.each(response.errors, function (key, err_value){
                            $('#save_errorList').append('<li>'+err_value+'</li>');
                        });
                    }
                    else if(response.status == 200)
                    {
                        $('#save_errorList').html("");
                        $('#save_errorList').addClass('d-none');

                        // this.reset();
                        $('#AddEmployeeForm').find('input').val('');
                        $('#AddEmployeeModal').modal('hide');
                        //To load data after adding input data
                        fetchEmployee();

                        swal({
                            title: "Good job!",
                            text: response.message,
                            icon: "success",
                        });
                        // swal(response.message);
                    }
                }
            });
        });
    });
</script>

@endsection

