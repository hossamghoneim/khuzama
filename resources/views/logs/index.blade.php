@extends('layouts.app',['title' => ' | Show All Logs'])

@section('styles')
    <!-- DataTables -->
    {{ Html::Style('plugins/datatables/dataTables.bootstrap4.min.css') }}
    {{ Html::Style('plugins/datatables/buttons.bootstrap4.min.css') }}
    <!-- Responsive datatable examples -->
    {{ Html::Style('plugins/datatables/responsive.bootstrap4.min.css') }}

    {{ Html::style('plugins/sweet-alert2/sweetalert2.min.css') }}


@endsection

@section('content')

    <div class="wrapper">
        <div class="container-fluid">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="{{ route('logs.index') }}">System Logs</a></li>
                                <li class="breadcrumb-item active">show all Logs </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-list"></i>
                            <span>show all Logs</span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->


            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                        <table id="responsive-datatable" class="table table-bordered table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Action</th>
                                <th>causer id</th>
                                <th>causer Type </th>
                                <th>subject Id </th>
                                <th>subject Type </th>
                                <th>Created at </th>
                                <th>Options</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div> <!-- end container -->
        </div>
    </div>
    <!-- end wrapper -->


@endsection

@section('scripts')

    <!-- Required datatable js -->
    {{ Html::script('plugins/datatables/jquery.dataTables.min.js') }}
    {{ Html::script('plugins/datatables/dataTables.bootstrap4.min.js') }}

    <!-- Responsive examples -->
    {{ Html::script('plugins/datatables/dataTables.responsive.min.js') }}
    {{ Html::script('plugins/datatables/responsive.bootstrap4.min.js') }}

    <!-- Buttons examples -->
    {{ Html::script('plugins/datatables/dataTables.buttons.min.js') }}
    {{ Html::script('plugins/datatables/buttons.bootstrap4.min.js') }}
    {{ Html::script('plugins/datatables/jszip.min.js') }}
    {{ Html::script('plugins/datatables/pdfmake.min.js') }}
    {{ Html::script('plugins/datatables/vfs_fonts.js') }}
    {{ Html::script('plugins/datatables/buttons.html5.min.js') }}
    {{ Html::script('plugins/datatables/buttons.print.min.js') }}


    <!-- Key Tables -->
    {{ Html::script('plugins/datatables/dataTables.keyTable.min.js') }}


    {{  Html::script('plugins/sweet-alert2/sweetalert2.min.js')  }}

    <script>
        $(document).ready(function() {

            // Responsive Datatable
            var table = $('#responsive-datatable').DataTable(
                {

                    processing: true,
                    serverSide: true,
                    aaSorting : [[0, 'desc']],
                    ajax: "{{ route('logs.index') }}",

                    columns: [
                        {data: 'id', name: 'id',orderable: true, searchable: false},

                        {data: 'description', name: 'description' ,orderable: true, searchable: true},


                        {data: 'causer_id', name: 'causer_id',orderable: true, searchable: true},
                        {data: 'causer_type', name: 'causer_type',orderable: true, searchable: true},

                        {data: 'subject_id', name: 'subject_id',orderable: true, searchable: true},
                        {data: 'subject_type', name: 'subject_type',orderable: true, searchable: true},


                        {data: 'created_at', name: 'created_at',orderable: true, searchable: true},
                        {data: 'options', name: 'options', orderable: false, searchable: false}

                    ] ,
                    responsive: !0,
                    "keys": true

                }
            );

            // Ajax Delete Post
            $('.table tbody ').on( 'click', 'td button[type=button]', function(event) {
                event.preventDefault();
                var $row = jQuery(this).closest("tr");
                var id = $row.find("button[type=button]").data("id");
                var name = $row.find("button[type=button]").data("name");
                swal({
                    title: 'Are you sure?',
                    text: "you will be not able to recover this record again!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#4fa7f3',
                    cancelButtonColor: '#d57171',
                    confirmButtonText: 'Yes Delete!',
                    cancelButtonText: 'Cancel'
                }).then(function () {
                    var data = {
                        _token: "{{ csrf_token() }}"
                    };
                    var path = "{{ route('users.delete',0) }}";
                    var url = path.replace(0, id);

                    $.ajax({
                        url: url,
                        type: "DELETE",
                        data: data,
                        success: function (data) {
                            swal(
                                'Done',
                                'Record data has been deleted successfully.',
                                'success'
                            );
                            table.ajax.reload();
                        }, error: function () {
                            swal("error", "system error", "error");
                        }
                    }); //end of ajax

                }).catch(swal.noop);
            });

        } );
    </script>
@endsection