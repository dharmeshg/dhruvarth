@extends('layouts.backend.index')
@section('main_content')
<style>

.checkbox-label {
    display: flex;
    align-items: center;
    font-size: 18px;
}

.checkbox-input {
    margin-right: 10px; 
}

</style>
<div class="pcoded-wrapper">
    <div class="pcoded-content">
        <div class="pcoded-inner-content">

            <div class="main-body">
                <div class="page-wrapper">
<div class="row">
    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-header">
                {{-- <strong id="title">Add New User</strong> --}}
                <h5>Add New User</h5>
            </div>
            <div class="card-body">
                        <div class="tab-pane p-3 active preview" role="tabpanel" id="preview-1000">
                            <form id="adduser" action="{{ route('users.add') }}" method="POST"
                                data-parsley-validate="">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id">
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Full Name</label>
                                    <input class="form-control" id="name" name="name" type="text"
                                        placeholder="Full Name" 
                                        data-parsley-required-message="Please Enter Full Name" required="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">E-mail</label>
                                    <input class="form-control" id="email" name="email" type="email"
                                        placeholder="E-Mail" data-parsley-required-message="Please Enter E-mail" required="">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Phone No</label>
                                    <input class="form-control imput-mask" id="phone" name="phone" type="text"
                                        placeholder="Phone Number" >
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlInput1">Website</label>
                                    <input class="form-control" id="website" name="website" type="url"
                                        placeholder="https://example.com">
                                </div>
                                <div class="mb-3">
                                    <button type="button" class="btn btn-sm btn-primary" id="setnewpass" style="display:none;">Set New Password</button>
                                </div>
                                <div class="mb-3" id="edit_pass">
                                    <label class="form-label" for="exampleFormControlInput1">Password</label>
                                    <div class="input-group">
                                        <input class="form-control" id="password" name="password" type="password" placeholder="Password" 
                                        data-parsley-required-message="Please Enter Password" required=""data-parsley-errors-container="#password-errors">
                                        <button type="button" class="btn btn-sm btn-primary" id="generatePassword">Generate</button>
                                        <button type="button" class="btn btn-sm btn-danger" id="cancel" style="display:none;">Cancel</button>
                                    </div>
                                    <div id="password-errors"></div>
                                    <div id="password-strength" class="text-muted"></div>
                                </div>
                                <div class="mb-3" id="user_notify">
                                    <label class="checkbox-label">
                                        <input class="checkbox-input" id="notify" name="notify" type="checkbox">
                                        Send User Notification
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="exampleFormControlTextarea1">Role</label>
                                    <select class="form-select" id="role" name="role"
                                        aria-label="Default select example" data-parsley-required-message="Please Select Role" required="">
                                        <option disabled selected>Select Role</option>
                                        <option value="subscriber">Subscriber</option>
                                        <option value="contributor">Contributor</option>
                                        <option value="author">Author</option>
                                        <option value="editor">Editor</option>
                                        <option value="administrator">Administrator</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-lg btn-primary">Save</button>
                                    <button type="button" id="clear" class="btn btn-lg btn-danger">Clear</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
    <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-header">
                {{-- <strong>User List</strong> --}}
                <h5>Users List</h5>
            </div>
            <div class="card-body card-block px-0 py-3">
                        <div class="table-responsive" role="tabpanel" id="">
                            <table class="table table-hover" id="myTable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">User</th>
                                        <th scope="col">E-Mail</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Action</th>
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

</div>
</div>
</div>
</div>


@endsection
@section('script')

<script>
$(document).ready(function() {
    var token = $("meta[name='csrf-token']").attr("content");
    var table = $('#myTable').DataTable({
        language: {
            search: "",
            "searchPlaceholder": "Search",
            "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>',
            paginate: {
                next: '&gt;', // or '→'
                previous: '&lt;' // or '←' 
            }
        },
        processing: true,
        bAutoWidth: false,
        aoColumns: [{
                sWidth: '1%'
            },
            {
                sWidth: '25%'
            },
            {
                sWidth: '25%'
            },
            {
                sWidth: '25%'
            },
            {
                sWidth: '24%'
            }
        ],
        ajax: {
            url: admin_url + "user/list",
            type: 'post',
            data: {
                _token: token,
            },
        },

        columns: [{
                data: 'ser_id',
                name: 'id'
            },
            {
                data: 'name',
                name: 'Name'
            },
            {
                data: 'email',
                name: 'E-mail'
            },
            {
                data: 'role',
                name: 'Role'
            },
            {
                data: 'action',
                name: 'Action'
            }
        ]
    });

 
})
</script>
<script>
    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        var deleteUrl = $(this).data('href');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You are about to delete the User!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    });

    $(document).on("click", ".edit", function () {
        var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).attr("data-id");
        $.ajax({
            url: '{{ route("users.edit") }}',
            type: "post",
            data: {
                _token: token,
                id: id,
            },
            success: function (data) {
                $("#setnewpass").css('display', 'block');
                $("#edit_pass").css('display', 'none');
                $("#password").prop('required', false);
                $("#user_notify").css('display', 'none');
                var data = JSON.parse(data);
                $("#user_id").val(data.id);
                $("#name").val(data.name);
                $("#email").val(data.email);
                $("#role").val(data.role);
                $("#website").val(data.website);
                $("#phone").val(data.phone);
                $("#title").html("Edit User");
            },
        });
    });

    $(document).on("click", "#setnewpass", function () {
        $("#setnewpass").css('display', 'none');
        $("#edit_pass").css('display', 'block');
        $("#cancel").css('display', 'block');
        $("#password").prop('required', true);
    });
    $(document).on("click", "#cancel", function () {
        $("#setnewpass").css('display', 'block');
        $("#edit_pass").css('display', 'none');
        $("#cancel").css('display', 'none');
        $("#password").prop('required', false);
        $("#password").val('');
    });

    $(document).on("click", "#clear", function() {
        $("#adduser")[0].reset();
        $("#user_id").val('');
        $("#setnewpass").css('display', 'none');
        $("#edit_pass").css('display', 'block');
        $("#password").prop('required', true);
        $("#user_notify").css('display', 'block');
    });
</script>
<script>
    $(document).ready(function () {
    // ...

    // Function to update the password strength indicator
    function updatePasswordStrength() {
        var password = $('#password').val();
        var passwordStrength = zxcvbn(password);

        // Display the password strength text and color
        var strengthText = ['Very Weak', 'Weak', 'Fair', 'Strong', 'Very Strong'][passwordStrength.score];
        var strengthColor = ['#1d2327', '#1d2327', '#1d2327', '#1d2327', '#1d2327'][passwordStrength.score];
        var backgroundColor = ['#ffabaf', '#facfd2', '#f5e6ab', '#b8e6bf', '#b8e6bf'][passwordStrength.score];
        $('#password-strength').text(strengthText).removeClass().addClass(strengthColor).css({
        'background-color': backgroundColor,
        'text-align': 'center'
        });
        
    }

    // Update the password strength as the user types
    $('#password').on('input', function () {
        updatePasswordStrength();
    });

    // ...

    $('#generatePassword').click(function () {
        var password = generateRandomPassword();
        $('#password').attr('type', 'text');
        $('#password').val(password);
        updatePasswordStrength();
    });

    function generateRandomPassword() {
        // You can implement your logic to generate a random password here
        // For simplicity, let's generate a 8-character password with letters and numbers
        var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var password = '';
        for (var i = 0; i < 12; i++) {
            var randomIndex = Math.floor(Math.random() * characters.length);
            password += characters.charAt(randomIndex);
        }
        return password;
    }

    // ...
});


</script>
@endsection