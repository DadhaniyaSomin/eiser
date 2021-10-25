@extends('layouts.master')
@section('content')

    <div tabindex="-1" class="modal pmd-modal fade" id="form-dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pmd-modal-border text-white bg-dark ">
                    <h2 class="modal-title">ADD SOMETHING AMAZING</h2>
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                </div>
                <div class="modal-body bg-light">
                    <form id="add_category" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="Product name" class="form-label">category Name</label>
                            <input type="text" class="form-control rounded-3 name" name="c_name" id="add_name"
                                autocomplete="off" placeholder="Enter the name">
                            <p id="name_error"></p>
                            @if ($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat"
                                type="button">cancel</button>
                            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat submit"
                                type="submit">ADD</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div tabindex="-1" class="modal pmd-modal fade" id="update_modal" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl-down">
            <div class="modal-content">
                <div class="modal-header pmd-modal-border">
                    <h2 class="modal-title">YOU CAN EDIT ANY TIME </h2>
                    <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
                </div>
                <div class="modal-body">
                    <form class="update_categories" id="simple_form" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="id" id="id" class="id" hidden>
                        <div class="mb-3">
                            <label for="Product name" class="form-label">category Name</label>
                            <input type="text" class="form-control rounded-3 c_name" id="c_name" name="c_name"
                                placeholder="Enter the name">
                            <p id="ename_error"></p>
                            @if ($errors->has('name'))
                                <div class="text-danger">{{ $errors->first('name') }}</div>
                            @endif
                        </div>


                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat"
                                type="button">cancel</button>
                            <button data-dismiss="modal" class="btn pmd-ripple-effect btn-dark pmd-btn-flat update"
                                type="submit">update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalConfirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-notify modal-danger" role="document">
            <!--Content-->
            <div class="modal-content text-center">
                <!--Header-->
                <div class="modal-header d-flex justify-content-center">
                    <p class="heading">Are you sure?</p>
                </div>

                <!--Body-->
                <div class="modal-body">

                    <i class="fa fa-times fa-4x animated rotateIn"></i>
                    <p>Are you sure you want to delte this Product .This can not be undone</p>


                </div>

                <!--Footer-->
                <div class="modal-footer flex-center">

                    <button data-dismiss="modal" class="btn pmd-ripple-effect btn-danger pmd-btn-flat" id="delete"
                        type="button">yes</button>
                    <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <!--Modal: modalConfirmDelete-->



    <div class="container mb-3">
        <button data-target="#form-dialog" data-toggle="modal" class="btn pmd-ripple-effect btn-primary pmd-btn-raised"
            type="button">ADD category</button>
    </div>



    <div class="container">

        <table id="myTable" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>name</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
@endsection

@push('scripts')

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('categories.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'c_name',
                        name: 'c_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        searchable: false,
                    },
                ],
            });



            //insert data into database 
            $(document).on('click', '.submit', (function(e) {
                e.preventDefault();
                
                var c_name = $('.name').val();
                console.log(c_name);

                $.ajax({
                    url: "{{ route('categories.store') }}",
                    data: {
                        c_name: c_name,
                        _token: "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    datatype: 'json',

                    success: function(data) {
                        $('#add_product').trigger('reset');
                        $('#myTable').DataTable().ajax.reload();
                    },
                });
            }
            ));


            //delete data from database
            $(document).on('click', '.category_delete', function(e) {
                var id = $(this).data('id');
                // console.log(id);

                $('#delete').click(function(e) {
                  
                    e.preventDefault();
                    $.ajax({
                        
                        url: "{{ url('admin/categories') }}" + '/' + id,
                        type: 'POST',
                        //dataType: 'JSON',
                        data: {
                            'id': id,
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(data) {
                            $('#myTable').DataTable().ajax.reload();
                        },
                    });

                });
            });


              //edit image from the database
              $(document).on('click', '.category_edit', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    console.log(id);
                    $.ajax({
                        url: "{{ url('admin/categories') }}" + '/' + id + "/edit",
                        type: 'get',
                        dataType: 'json',
                        data: {
                            'id': id,
                        },
                        success: function(data) {
                            $('#id').val(data.id);
                            $('#c_name').val(data.c_name);                   
                        }
                    });
                });


                  //update the data
                  $(document).on('click', '.update', (function(e) {
                    e.preventDefault();
                    var id = $('#id').val();
                    var c_name = $('#c_name').val();
                   

                    console.log(name);
                    //var formData = new FormData(this);
                    $.ajax({
                        url: "{{ url('admin/categories') }}" + '/' + id,
                        data: {
                            c_name: c_name,
                            _token: "{{ csrf_token() }}",
                            _method: 'PATCH',

                        },
                        type: 'POST',
                        datatype: 'json',
                        success: function(data) {

                            $('#myTable').DataTable().ajax.reload();
                            // ("#form-dialog").display.none();
                        },
                    });

                }));

                $('#name_error').hide();
                $('alert alert-danger').reomove

                var name_error = true;
                //for add the Inter tha data  
                $('#add_name').keyup(function() {
                    nameCheck();
                });

                $('#c_name').keyup(function() {
                    enameCheck();
                });

                
                function nameCheck() {
                    var name_val = $('#add_name').val();
                    if (name_val.length == 0) {
                        $('#name_error').show();
                        $('#name_error').html('Please enter tha name');
                        $('#name_error').focus();
                        $('#name_error').css('color', 'red');
                        name_error = false;
                        return false;
                    } else {
                        $('#name_error').hide();
                        $('#add_price').focus(
                            function() {
                                $(this).css({
                                    'border-color': '#FFFFEEE'
                                });
                            });
                    }
                    if (name_val.length < 3 || name_val.length > 10) {
                        $('#name_error').show();
                        $('#name_error').html('Please enter the name bwtween 3 to 10');
                        $('#name_error').focus();
                        $('#name_error').css('color', 'red');
                        name_error = false;
                        return false;
                    } else {
                        $('#name_error').hide();
                    }
                };
                function enameCheck() {
                    var name_val = $('#c_name').val();
                    if (name_val.length == 0) {
                        $('#ename_error').show();
                        $('#ename_error').html('Please enter tha name');
                        $('#ename_error').focus();
                        $('#ename_error').css('color', 'red');
                        ename_error = false;
                        return false;
                    } else {
                        $('#ename_error').hide();
                        
                    }
                    if (name_val.length < 3 || name_val.length > 10) {
                        $('#ename_error').show();
                        $('#ename_error').html('Please enter the name bwtween 3 to 10');
                        $('#ename_error').focus();
                        $('#ename_error').css('color', 'red');
                        ename_error = false;
                        return false;
                    } else {
                        $('#ename_error').hide();
                    }
                };

        });
    </script>

@endpush
