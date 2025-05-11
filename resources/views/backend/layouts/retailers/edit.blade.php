@extends('backend.app')

@section('title', 'Retailers')

@push('styles')

@endpush


@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Retailers</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item">Retailers</li>
                                <li class="breadcrumb-item active">Edit</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->


            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">Edit retailer</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <p class="text-muted">Edit retailer information below.</p>
                            <div class="live-preview">
                                <form action="{{ route('admin.retailer.update', $retailer->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xxl-3">
                                            <!-- Retailer Name -->
                                            <div class="mb-3">
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Enter Retailer Name" value="{{ old('title', $retailer->title) }}">
                                                @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-3">
                                            <!-- Retailer Website -->
                                            <div class="mb-3">
                                                <input type="text" class="form-control @error('retailer_website') is-invalid @enderror" id="retailer_website" name="retailer_website" placeholder="Enter Retailer Website URL" value="{{ old('retailer_website', $retailer->retailer_website) }}">
                                                @error('retailer_website')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div> {{-- end row --}}
                                    <div class="row">
                                        <div class="col-xxl-3">
                                            <!-- Data URL -->
                                            <div class="mb-3">
                                                <input type="text" class="form-control @error('data_url') is-invalid @enderror" id="data_url" name="data_url" placeholder="Enter Data URL" value="{{ old('data_url', $retailer->data_url) }}" disabled>
                                                @error('data_url')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xxl-3">
                                            <!-- Type -->
                                            <div class="mb-3">
                                                <select class="form-select @error('type') is-invalid @enderror" aria-label="Select Type" name="type" disabled>
                                                    <option value="" disabled {{ old('type', $retailer->type) === null ? 'selected' : '' }}>Select Type</option>
                                                    <option value="1" {{ old('type', $retailer->type) == 1 ? 'selected' : '' }}>XML</option>
                                                    <option value="2" {{ old('type', $retailer->type) == 2 ? 'selected' : '' }}>JSON</option>
                                                    {{-- <option value="3">Standard Text</option> --}}
                                                </select>
                                                @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xxl-6">
                                            <!-- Update Interval -->
                                            <div class="mb-3">
                                                <input type="text" class="form-control @error('update_interval') is-invalid @enderror" id="update_interval" name="update_interval" placeholder="Enter Update Interval" value="{{ old('update_interval', $retailer->update_interval) }}">
                                                <div class="text-muted">
                                                    <strong>Enter the update interval as one of the following:</strong>
                                                    <ul class="mt-1">
                                                        <li><strong>live</strong>: Updates continuously in real-time.</li>
                                                        <li><strong>never</strong>: Data will never be updated automatically.</li>
                                                        <li><strong>Numeric Value</strong> (e.g., 5, 10, 30): Represents the interval in minutes for automatic updates.</li>
                                                    </ul>
                                                </div>
                                                @error('update_interval')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3">
                                        <!-- Submit Button -->
                                        <div class="">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            {{--<div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-header align-items-center d-flex">
                            <h4 class="card-title mb-0 flex-grow-1">All tips and care items</h4>
                            <div class="flex-shrink-0">
                                <a href="{{ route('admin.tips_care.create') }}" class="btn btn-primary waves-effect waves-light">
                                    <i class="bx bx-plus me-1"></i> Add New
                                </a>
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <div class="live-preview">
                                <table class="table table-hover" id="data-table">
                                    <thead>
                                    <tr>
                                        <th>SI</th>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!-- Rows will be populated dynamically -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>--}}
            <!--end row-->


        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

@endsection


@push('scripts')
    {{--== SWEET ALERT ==--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- ===================== yazra data table ==============--}}
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            var searchable = [];
            var selectable = [];
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                }
            });

            if (!$.fn.DataTable.isDataTable('#data-table')) {
                let dTable = $('#data-table').DataTable({
                    order: [],
                    lengthMenu: [
                        [10, 25, 50, 100, 200, 500, -1],
                        ["10", "25", "50", "100", "200", "500", "All"]
                    ],

                    pageLength: 10,
                    processing: true,
                    responsive: true,
                    serverSide: true,

                    language: {
                        processing: `<div class="text-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                            <span class="visually-hidden">Loading...</span>
                          </div>
                            </div>`,
                        lengthMenu: '_MENU_',
                        search: '',
                        searchPlaceholder: 'Search..'
                    },
                    scroller: {
                        loadingIndicator: false
                    },
                    pagingType: "full_numbers",
                    dom: "<'row justify-content-between table-topbar'<'col-md-2 col-sm-4 px-0'l><'col-md-2 col-sm-4 px-0'f>>tipr",
                    ajax: {
                        url: "{{ route('admin.tips_care.index') }}",
                        type: "get",
                    },

                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                        {
                            data: 'title',
                            name: 'title',
                            orderable: true,
                            searchable: true
                        },

                        {
                            data: 'content',
                            name: 'content',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'image',
                            name: 'image',
                            orderable: true,
                            searchable: true
                        },

                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                });

                new DataTable('#example', {
                    responsive: true
                });
            }
        });


        // Sweet alert Delete confirm
        const deleteAlert = (id) => {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteAuction(id);
                }
            });
        }
        // deleting an auction
        const deleteAuction = (id) => {
            try {
                let url = '{{ route('admin.tips_care.destroy', ':id') }}';
                let csrfToken = `{{ csrf_token() }}`;
                $.ajax({
                    type: "DELETE",
                    url: url.replace(':id', id),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: (response) => {
                        $('#data-table').DataTable().ajax.reload();
                        if (response.success === true) {
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                            });
                        } else if (response.errors === true) {
                            console.log(response.errors[0]);
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        } else {
                            toastr.success(response.message);
                        }
                    },
                    error: (error) => {
                        console.log(error.message);
                        errorAlert()
                    }
                })
            } catch (e) {
                console.log(e)
            }
        }
    </script>
@endpush
