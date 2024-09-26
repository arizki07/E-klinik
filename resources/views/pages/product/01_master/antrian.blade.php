@extends('layouts.apps')
@section('content')
    <style>
        .small-toast {
            font-size: 12px;
            padding: 10px;
        }

        td.cuspad0 {
            padding-top: 1px;
            padding-bottom: 1px;
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
                <span class="bg-200 dark__bg-1100 pe-3">Master &amp; Antrian</span>
                <span class="border position-absolute top-50 translate-middle-y w-100 start-0 z-index--1"></span>
            </h5>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6 col-xxl-3">
            <div class="card h-lg-100 card-clickable" data-poli="Poli Umum">
                <div class="bg-holder bg-card"
                    style="background-image:url(asset/public/assets/img/icons/spot-illustrations/corner-1.png);"></div>
                <div class="card-body position-relative">
                    <h5 class="text-warning"><i class="fas fa-hospital"></i> POLI UMUM</h5>
                    <p class="fs--1 mb-0">Klik untuk mendaftar antrian Poli Umum</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3">
            <div class="card h-lg-100 card-clickable" data-poli="Poli Gigi">
                <div class="bg-holder bg-card"
                    style="background-image:url(asset/public/assets/img/icons/spot-illustrations/corner-2.png);"></div>
                <div class="card-body position-relative">
                    <h5 class="text-warning"><i class="fas fa-tooth"></i> POLI GIGI</h5>
                    <p class="fs--1 mb-0">Klik untuk mendaftar antrian Poli Gigi</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3">
            <div class="card h-lg-100 card-clickable" data-poli="Poli KB">
                <div class="bg-holder bg-card"
                    style="background-image:url(asset/public/assets/img/icons/spot-illustrations/corner-3.png);"></div>
                <div class="card-body position-relative">
                    <h5 class="text-warning"><i class="fas fa-female"></i> POLI KB</h5>
                    <p class="fs--1 mb-0">Klik untuk mendaftar antrian Poli KB</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xxl-3">
            <div class="card h-lg-100 card-clickable" data-poli="Poli Mata">
                <div class="bg-holder bg-card"
                    style="background-image:url(asset/public/assets/img/icons/spot-illustrations/corner-3.png);"></div>
                <div class="card-body position-relative">
                    <h5 class="text-warning"><i class="fas fa-eye"></i> POLI MATA</h5>
                    <p class="fs--1 mb-0">Klik untuk mendaftar antrian Poli Mata</p>
                </div>
            </div>
        </div>
    </div>

    {{-- table  --}}
    <div class="card z-index-1 mb-3 mt-3">
        <div class="card-body px-3 py-3">
            <div class="table-responsive">
                <table style="width:100%; height: 100%;font-size:13px;"
                    class="table table-bordered table-vcenter card-table table-hover text-nowrap datatable datatable-antrian">
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
            var tableAntrian = $('.datatable-antrian').DataTable({
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
                    "url": "{{ route('getAntrian.index') }}",
                    "data": function(data) {
                        data._token = "{{ csrf_token() }}";
                    }
                },
                "columns": [{
                        title: 'ACTION',
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: "cuspad0 cuspad1 text-center clickable cursor-pointer"
                    },
                    {
                        title: 'NAME',
                        data: 'nama_pasien',
                        name: 'nama_pasien',
                        className: "cuspad0 cuspad1 text-center clickable cursor-pointer"
                    },
                    {
                        title: 'NO ANTRIAN',
                        data: 'no_antrian',
                        name: 'no_antrian',
                        className: "cuspad0 cuspad1 text-center clickable cursor-pointer"
                    },
                    {
                        title: 'SERVICE',
                        data: 'service',
                        name: 'service',
                        className: "cuspad0 cuspad1 text-center cursor-pointer"
                    },
                    {
                        title: 'STATUS',
                        data: 'status',
                        name: 'status',
                        className: "cuspad0 clickable cursor-pointer"
                    },
                ],

            });

            /*-----------------------creat antrian------------------------ */
            $('.card-clickable').on('click', function() {
                var poli = $(this).data('poli');
                $.ajax({
                    url: '/antrian/create',
                    type: 'POST',
                    data: {
                        poli: poli,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Berhasil menambahkan antrian, ' + poli + '',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true,
                            customClass: {
                                popup: 'small-toast'
                            }
                        }).then(() => {

                            location.reload();
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Gagal menambahkan antrian!',
                            showConfirmButton: false,
                            timer: 4000,
                            timerProgressBar: true
                        });
                    }
                });
            });
        });
    </script>
@endsection
