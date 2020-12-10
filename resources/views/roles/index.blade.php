@extends('layouts.app',['title'=>' |  View All Roles '])

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
        <div class="container-fluid" >
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group pull-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                                <li class="breadcrumb-item active">View All Roles </li>
                            </ol>
                        </div>
                        <h4 class="page-title">
                            <i class="fa fa-list"></i>
                            <span>View All Roles</span>
                        </h4>
                    </div>
                </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-box">

                        <div class="card-body">
                            {{-- dd(auth()->user()->favorite(\App\File::class)) --}}
                            <div class="row">
                                <div class="col-md-12">

                                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                           width="100%">
                                        <thead>
                                        <tr >

                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Users Count</th>
                                            <th> Permissions Count</th>
                                            <th><i class="fa fa-calendar-times-o"></i>  Created at</th>
                                            <th> <i class="icon icon-options"></i> </th>

                                        </tr>
                                        </thead>
                                        <tbody class="text-center">
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
    <hr>
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

            var table = $('#datatable-responsive').DataTable({

                processing: true,
                serverSide: true,
                aaSorting : [[0, 'desc']],
                ajax: "{{ route('roles.index') }}",
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    var index = iDisplayIndex +1;
                    $('td:eq(0)',nRow).html(index);
                    return nRow;
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name',orderable: true, searchable: true},
                    {data: 'users_count', name: 'users_count',orderable: true, searchable: true},
                    {data: 'permissions_count', name: 'permissions_count',orderable: true, searchable: true},
                    {data: 'created_at', name: 'created_at',orderable: true, searchable: false},
                    {data: 'options', name: 'options', orderable: false, searchable: false}

                ]
            });

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
                    var path = "{{ route('roles.delete',0) }}";
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
        });
    </script>
@endsection