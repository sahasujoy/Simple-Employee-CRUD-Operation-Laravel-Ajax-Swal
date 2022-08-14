<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Engineer's CRUD App</title>
    {{-- bootstrap 5 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    {{-- datatable.net  --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css"/>
    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>
<body>
{{-- add new employee modal start --}}
<div class="modal fade" id="addEngineerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Add New Engineer</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="{{ route('engineer.store') }}" method="POST" id="add_engineer_form" enctype="multipart/form-data">
      @csrf
      <div class="modal-body p-4 bg-light">
        <div class="row">
          <div class="col-lg">
            <label for="fname">First Name</label>
            <input type="text" name="fname" class="form-control" placeholder="First Name" required>
          </div>
          <div class="col-lg">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
          </div>
        </div>
        <div class="my-2">
          <label for="email">E-mail</label>
          <input type="email" name="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="my-2">
          <label for="phone">Phone</label>
          <input type="tel" name="phone" class="form-control" placeholder="Phone" required>
        </div>
        <div class="my-2">
          <label for="post">Post</label>
          <input type="text" name="post" class="form-control" placeholder="Post" required>
        </div>
        <div class="my-2">
          <label for="avatar">Select Avatar</label>
          <input type="file" name="avatar" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="add_engineer_btn" class="btn btn-primary">Add Engineer</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- add new employee modal end --}}

{{-- edit employee modal start --}}
<div class="modal fade" id="editEngineerModal" tabindex="-1" aria-labelledby="exampleModalLabel"
data-bs-backdrop="static" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Edit Engineer</h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <form action="#" method="POST" id="edit_engineer_form" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="emp_id" id="emp_id">
      <input type="hidden" name="emp_avatar" id="emp_avatar">
      <div class="modal-body p-4 bg-light">
        <div class="row">
          <div class="col-lg">
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" class="form-control" placeholder="First Name" required>
          </div>
          <div class="col-lg">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" class="form-control" placeholder="Last Name" required>
          </div>
        </div>
        <div class="my-2">
          <label for="email">E-mail</label>
          <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="my-2">
          <label for="phone">Phone</label>
          <input type="tel" name="phone" id="phone" class="form-control" placeholder="Phone" required>
        </div>
        <div class="my-2">
          <label for="post">Post</label>
          <input type="text" name="post" id="post" class="form-control" placeholder="Post" required>
        </div>
        <div class="my-2">
          <label for="avatar">Select Avatar</label>
          <input type="file" name="avatar" class="form-control">
        </div>
        <div class="mt-2" id="avatar">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Engineer</button>
      </div>
    </form>
  </div>
</div>
</div>
{{-- edit employee modal end --}}

<div class="container">
  <div class="row my-5">
    <div class="col-lg-12">
      <div class="card shadow">
        <div class="card-header bg-danger d-flex justify-content-between align-items-center">
          <h3 class="text-light">Manage Engineers</h3>
          <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEngineerModal"><i
              class="bi-plus-circle me-2"></i>Add New Engineer</button>
        </div>
        <div class="card-body" id="show_all_engineers">
          <h1 class="text-center text-secondary my-5">Loading...</h1>
        </div>
      </div>
    </div>
  </div>
</div>
    {{-- jquery cdn --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- bootstrap 5 cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    {{-- datatable.net  --}}
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    {{-- sweetalert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        fetchAllEngineers();
        //fetch all engineers
        function fetchAllEngineers()
        {
            $.ajax({
                url: '{{ route('engineer.fetchall') }}',
                method: 'get',
                success: function (res) {
                    //console.log(res);
                    
                  }
            })
        }
        //add engineer ajax request
        $("#add_engineer_form").submit(function(e){
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_engineer_btn").text('Adding...');
            $.ajax({
                url: '{{ route('engineer.store') }}',
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res)
                {
                    // console.log(res);
                    if(res.status == 200)
                    {
                        Swal.fire(
                            'Added!',
                            'Engineer Added Successfully!',
                            'success'
                        )
                    }
                    $("#add_engineer_btn").text('Add Employee');
                    $("#add_engineer_form")[0].reset();
                    $("#addEngineerModal").modal('hide');
                }
            });
        });
    </script>
</body>
</html>
