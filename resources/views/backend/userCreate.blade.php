@extends('backend.layouts.master')

@section('title','User Creation')
@section('style')
<style>
    /* .multiselect {
  width: 200px;
} */

    .selectBox {
        position: relative;
    }

    .selectBox select {
        width: 100%;
        font-weight: bold;
    }

    .overSelect {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    #checkboxes {
        display: none;
        border: 1px #dadada solid;
    }

    #checkboxes label {
        display: block;
    }

    #checkboxes label:hover {
        background-color: #1e90ff;
    }

</style>
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Subheader-->
    <div class="subheader py-2 py-lg-4 subheader-solid" id="kt_subheader">
        <div class="container-fluid d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex align-items-center flex-wrap mr-2">
                <!--begin::Page Title-->
                <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">User Creation</h5>
            </div>
            <!--end::Info-->
        </div>
    </div>
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Card-->
            <div class="card card-custom">
                {{-- <div class="card-header flex-wrap py-5">
            <div class="card-title">
              <h3 class="card-label">Form </h3>
            </div>
        </div> --}}
                <div class="card-body">
                    <!--begin: Datatable-->
                    <div class="row">
                        <div class="col-md-8 col-xs-12 col-sm-12 offset-md-2">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul style="margin-bottom: 0rem;">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (Session::has('success'))
                            <div class="alert alert-success" role="success">
                                {{ Session::get('success') }}
                            </div>
                            @endif
                            @if (Session::has('error'))
                            <div class="alert alert-danger" role="success">
                                {{ Session::get('error') }}
                            </div>
                            @endif
                            {{-- <form action="{{route('event.store')}}" method="post" onsubmit="return confirm('Are you sureyou want to submit?');" name="registration"> --}}
                            <form action="{{route('user.store')}}" method="post" onsubmit="return confirm('Are you sureyou want to submit?');" name="registration">
                            @csrf
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Username</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Password</label>
                                        <input type="text" name="password" class="form-control" required>
                                    </div>
                                </div><!-- /.box-body -->


                                <div class="box-footer">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="reset" onclick="resetForm()" class="btn btn-warning btn-block">Reset</button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-secondary btn-block">Create</button>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!--end: Datatable-->
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
</div>
@endsection

@section('script')
<script>
    
    // multiple selection
    var expanded = false;
    
    function showCheckboxes() {
        var checkboxes = document.getElementById("checkboxes");
        if (!expanded) {
            checkboxes.style.display = "block";
            expanded = true;
        } else {
            checkboxes.style.display = "none";
            expanded = false;
        }
    }
    

    function resetForm($form) {
        $(".area").val('').trigger('change')
        $('#FormControlSelect2').empty();
        $('#checkboxes').empty();
        checkboxes.style.display = "none";
    }

    // dependency dropdown
    $(document).ready(function () {
        $('#FormControlSelect1').on('change', function () {
            let id = $(this).val();
            $('#FormControlSelect2').empty();
            $('#FormControlSelect2').append(
                `<option value="" disabled selected>Processing...</option>`);
            $.ajax({
                type: 'GET',
                url: 'fetch/' + id,
                success: function (response) {
                    var response = JSON.parse(response);
                    console.log(response);
                    $('#FormControlSelect2').empty();
                    $('#FormControlSelect2').append(
                        `<option value="" disabled selected>Select Sub Category*</option>`
                        );
                    $('#checkboxes').empty();
                    var count = 0;
                    response.forEach(element => {
                        count += 1;
                    });
                    if (count < 5) {
                        response.forEach(element => {
                            $('#checkboxes').append(`<label class="checkbox-inline">
                    <input type="checkbox"  id="division_id"  checked  name="branch_id[]" value="${element['branch_id']}" onclick="return false">
                    ${element['branch_name']}
                                </label>
                                `);
                        });

                    } else {
                        response.forEach(element => {
                            $('#checkboxes').append(`<label class="checkbox-inline">
                    <input type="checkbox" id="division_id"  name="branch_id[]" value="${element['branch_id']}">
                    ${element['branch_name']}
                                </label>
                                `);
                        });
                    }
                }
            });
        });
    });
    // maximum 4 select 
    $(document).ready(function () {
        $('.area').select2();

        $(document).on('click', 'input[type=checkbox]', function () {
            if ($('input[type=checkbox]:checked').length > 4) {
                $(this).prop('checked', false);
                alert("allowed only 4");
            }
        });
    });
</script>


@endsection
