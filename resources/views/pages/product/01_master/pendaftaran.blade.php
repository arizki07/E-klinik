@extends('layouts.apps')
@section('content')
    <style>
        td.cuspad0 {
            padding-top: 10px;
            padding-bottom: 10px;
            padding-right: 13px;
            padding-left: 13px;
        }

        td.cuspad1 {
            text-transform: uppercase;
        }
    </style>
    <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-300"></i>
            <i class="fa-inverse fa-stack-1x text-primary fas fa-percentage"></i></span>
        <div class="col">
            <h5 class="mb-0 text-primary position-relative mt-1">
                <span class="bg-200 dark__bg-1100 pe-3">Master User &amp; Auth</span>
                <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
            </h5>
        </div>
    </div>
    <div class="card z-index-1 mb-3">
        <div class="card-header bg-header">
            <div class="row flex-between-center">
                <div class="col-6 col-sm-auto d-flex align-items-center pe-0">
                    <h5 class="fs-0 mb-0 text-nowrap py-2 py-xl-0 text-black">Tabel </h5>
                </div>
                <div class="row flex-between-center">
                    <div class="col-4 col-sm-auto ms-auto text-end">
                        <div class="d-none" id="table-purchases-actions">
                            <button class="btn btn-falcon-default text-danger btn-sm ms-2" type="button" id="btn-process">
                                <span class="fas fa-trash fs--1 text-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" style="margin-right: 5px;"></span>Proses Hapus
                            </button>
                        </div>

                        <div id="table-purchases-replace-element" class="d-flex align-items-center">
                            <a class="btn btn-falcon-default btn-sm" type="button" href="#">
                                <span class="fas fa-plus" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ms-1">New</span>
                            </a>
                            <button class="btn btn-falcon-default btn-sm mx-2" type="button">
                                <span class="fas fa-filter" data-fa-transform="shrink-3 down-2"></span>
                                <span class="d-none d-sm-inline-block ms-1">Filter</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <hr>
        <div class="card-body px-3 py-3">
            <div class="table-responsive">
                <table style="width:100%; height: 100%;font-size:13px;"
                    class="table table-bordered table-vcenter card-table table-hover text-nowrap datatable datatable-pendaftaran">
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;

            dt.one('preXhr', function(e, s, data) {
                data.start = 0;
                data.length = 2147483647;

                dt.one('preDraw', function(e, settings) {
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    }
                    settings._iDisplayStart = oldStart;
                    data.start = oldStart;
                });
            });

            dt.ajax.reload();
        }

        $(document).ready(function() {
            var tablePendaftaran = $('.datatable-pendaftaran').DataTable({
                "processing": true,
                "serverSide": false,
                "scrollX": false,
                "scrollCollapse": false,
                "pagingType": 'full_numbers',
                "dom": "<'card-header h3' B>" +
                    "<'card-body border-bottom py-3' <'row'<'col-sm-6'l><'col-sm-6'f>> >" +
                    "<'table-responsive' <'col-sm-12'tr> >" +
                    "<'card-footer' <'row'<'col-sm-5'i><'col-sm-7'p> >>",
                "lengthMenu": [
                    [10, 10, 25, 50, -1],
                    ['Default', '10', '25', '50', 'Semua']
                ],
                "buttons": [{
                        extend: 'copyHtml5',
                        className: 'btn btn-teal',
                        text: '<i class="fa fa-copy text-white"></i> Copy',
                        action: newexportaction,
                    },
                    {
                        extend: 'excelHtml5',
                        autoFilter: true,
                        className: 'btn btn-success',
                        text: '<i class="fa fa-file-excel text-white"></i> Excel',
                        action: newexportaction,
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf text-white"></i> Pdf',
                    },
                ],
                "language": {
                    "lengthMenu": "Menampilkan _MENU_",
                    "zeroRecords": "Data Tidak Ditemukan",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ total data",
                    "infoEmpty": "Data Tidak Ditemukan",
                    "infoFiltered": "(Difilter dari _MAX_ total records)",
                    "processing": '<div class="container container-slim py-4"><div class="text-center"><div class="mb-3"></div><div class="text-secondary mb-3">Loading Data...</div><div class="progress progress-sm"><div class="progress-bar progress-bar-indeterminate"></div></div></div>',
                    "search": '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>',
                    "paginate": {
                        "first": '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left-pipe" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 6v12"></path><path d="M18 6l-6 6l6 6"></svg>',
                        "last": '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right-pipe" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 6l6 6l-6 6"></path><path d="M17 5v13"></path></svg>',
                        "next": '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24h24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>',
                        "previous": '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24h24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg>',
                    },
                },
                "ajax": {
                    "url": "{{ route('getPendaftaran.index') }}",
                    "data": function(data) {
                        data._token = "{{ csrf_token() }}";
                    }
                },
                "columns": [{
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        title: 'NAME',
                        data: 'nama_pasien',
                        name: 'nama_pasien',
                        className: "cuspad0 cuspad1 text-center clickable cursor-pointer"
                    },
                    {
                        title: 'KTP',
                        data: 'ktp',
                        name: 'ktp',
                        className: "cuspad0 cuspad1 text-center clickable cursor-pointer"
                    },
                    {
                        title: 'TANGGAL LAHIR',
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        className: "cuspad0 cuspad1 text-center cursor-pointer"
                    },
                    {
                        title: 'ALAMAT',
                        data: 'alamat',
                        name: 'alamat',
                        className: "cuspad0 clickable cursor-pointer"
                    },
                    {
                        title: 'NO HP',
                        data: 'no_tlpn',
                        name: 'no_tlpn',
                        className: "cuspad0 clickable cursor-pointer"
                    },
                    {
                        title: 'JENIS',
                        data: 'jenis_pasien',
                        name: 'jenis_pasien',
                        className: "cuspad0 clickable cursor-pointer"
                    },
                    {
                        title: 'BPJS',
                        data: 'bpjs_status',
                        name: 'bpjs_status',
                        className: "cuspad0 clickable cursor-pointer"
                    },
                ],

            });
        });
    </script>
@endsection
