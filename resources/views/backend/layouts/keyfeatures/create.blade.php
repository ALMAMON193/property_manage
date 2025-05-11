@extends('backend.app')

@section('title', 'Key Features')

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
    <style>
        .ck-editor__editable[role="textbox"] {
            min-height: 150px;
        }
        .dropify-wrapper .dropify-message p {
            font-size:35px !important;
        }
        #qb-toolbar-container{
            display : none !important;
        }
    </style>
@endpush


@section('content')

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-galaxy-transparent">
                        <h4 class="mb-sm-0">Key Features</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Home</a></li>
                                <li class="breadcrumb-item active">Key Features</li>
                                <li class="breadcrumb-item active">Create</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Add key features</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <p class="text-muted">Add Caliber details as key features.</p>
                            <div class="live-preview">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <form action="{{ route('admin.key_feature.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf

                                            <!-- Category -->
                                            <div class="mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" data-choices data-choices-sorting="true" id="category_id">
                                                    <option selected disabled>Select Category</option>
                                                    @forelse($categories as $category)
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                    @empty
                                                    @endforelse
                                                </select>
                                                @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Caliber Names -->
                                            <div class="mb-3">
                                                <label for="caliber_names" class="form-label">Caliber Names</label>
                                                <input type="text" class="form-control @error('caliber_names') is-invalid @enderror" id="caliber_names" name="caliber_names" value="{{ old('caliber_names') }}" placeholder="Enter Caliber Names">
                                                <strong class="text-primary">You can enter multiple names for a caliber here. Separate each name with a semicolon ';'</strong>
                                                @error('caliber_names')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Bullet Type -->
                                            <div class="mb-3">
                                                <label for="bullet_type" class="form-label">Bullet Type</label>
                                                <textarea class="form-control @error('bullet_type') is-invalid @enderror" id="muzzle_velocity" name="bullet_type" rows="3" placeholder="Enter Bullet Type">{{ old('bullet_type') }}</textarea>
                                                @error('bullet_type')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Muzzle Velocity -->
                                            <div class="mb-3">
                                                <label for="muzzle_velocity" class="form-label">Muzzle Velocity</label>
                                                <textarea class="form-control @error('muzzle_velocity') is-invalid @enderror" id="muzzle_velocity" name="muzzle_velocity" rows="3" placeholder="Enter Muzzle Velocity">{{ old('muzzle_velocity') }}</textarea>
                                                @error('muzzle_velocity')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Muzzle Energy -->
                                            <div class="mb-3">
                                                <label for="muzzle_energy" class="form-label">Muzzle Energy</label>
                                                <textarea class="form-control @error('muzzle_energy') is-invalid @enderror" id="muzzle_energy" name="muzzle_energy" rows="3" placeholder="Enter Muzzle Energy">{{ old('muzzle_energy') }}</textarea>
                                                @error('muzzle_energy')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Compatibility -->
                                            <div class="mb-3">
                                                <label for="compatibility" class="form-label">Compatibility</label>
                                                <textarea class="form-control @error('compatibility') is-invalid @enderror" id="compatibility" name="compatibility" rows="3" placeholder="Enter Compatibility">{{ old('compatibility') }}</textarea>
                                                @error('compatibility')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Use Case -->
                                            <div class="mb-3">
                                                <label for="use_case" class="form-label">Use Case</label>
                                                <textarea class="form-control @error('use_case') is-invalid @enderror" id="use_case" name="use_case" rows="3" placeholder="Enter Use Case">{{ old('use_case') }}</textarea>
                                                @error('use_case')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Image Upload -->
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" data-default-file="" class="dropify form-control @error('image') is-invalid @enderror" name="image" id="image">
                                                @error('image')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Submit -->
                                            <div>
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
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
    {{-- ================== dropify ===================--}}
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>



    <script>



        $('.dropify').dropify();
    </script>
@endpush
