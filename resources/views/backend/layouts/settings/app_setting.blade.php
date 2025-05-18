@extends('backend.app')

@section('title', 'App Setting')

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
                        <h4 class="mb-sm-0">App Setting</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item">Settings</li>
                                <li class="breadcrumb-item active">App Setting</li>
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
                            <h4 class="card-title mb-0 flex-grow-1">Update app setting</h4>
                            <div class="flex-shrink-0">
                            </div>
                        </div><!-- end card header -->
                        <div class="card-body">
                            <p class="text-muted">Update app setting information below.</p>
                            <div class="live-preview">
                                <form action="{{ route('admin.setting.appSetting.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- App Name -->
                                    <div class="mb-3">
                                        <label for="app_name" class="form-label">App Name</label>
                                        <input type="text" class="form-control @error('app_name') is-invalid @enderror" id="app_name" name="app_name" value="{{ old('app_name', env('APP_NAME')) }}">
                                        @error('app_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Tagline -->
                                    <div class="mb-3">
                                        <label for="tagline" class="form-label">Tagline</label>
                                        <input type="text" class="form-control @error('tagline') is-invalid @enderror" id="tagline" name="tagline" value="{{ old('tagline', $setting->tagline ?? '') }}">
                                        @error('tagline') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-4">
                                            <!-- Logo Upload -->
                                            <div class="mb-3">
                                                <label for="logo" class="form-label">Logo</label>
                                                <input type="file" data-default-file="{{ asset($setting->logo ?? 'no-image.png') }}" class="dropify form-control @error('logo') is-invalid @enderror" name="logo" id="logo">
                                                @error('logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- Footer Logo Upload -->
                                            <div class="mb-3">
                                                <label for="footer_logo" class="form-label">Footer Logo</label>
                                                <input type="file" data-default-file="{{ asset($setting->footer_logo ?? 'no-image.png') }}" class="dropify form-control @error('footer_logo') is-invalid @enderror" name="footer_logo" id="footer_logo">
                                                @error('footer_logo') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <!-- Favicon Upload -->
                                            <div class="mb-3">
                                                <label for="favicon" class="form-label">Favicon</label>
                                                <input type="file" data-default-file="{{ asset($setting->favicon ?? 'no-image.png') }}" class="dropify form-control @error('favicon') is-invalid @enderror" name="favicon" id="favicon">
                                                @error('favicon') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $setting->phone ?? '') }}">
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $setting->email ?? '') }}">
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $setting->address ?? '') }}">
                                        @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Footer Description (with CKEditor) -->
                                    <div class="mb-3">
                                        <label for="footer_description" class="form-label">Footer Description</label>
                                        <textarea class="form-control @error('footer_description') is-invalid @enderror" id="footer_description" name="footer_description" rows="3">{{ old('footer_description', $setting->footer_description ?? '') }}</textarea>
                                        @error('footer_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Copyright Text -->
                                    <div class="mb-3">
                                        <label for="copy_right_text" class="form-label">Copyright Text</label>
                                        <input type="text" class="form-control @error('copy_right_text') is-invalid @enderror" id="copy_right_text" name="copy_right_text" value="{{ old('copy_right_text', $setting->copy_right_text ?? '') }}">
                                        @error('copy_right_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Meta Keywords -->
                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $setting->meta_keywords ?? '') }}">
                                        @error('meta_keywords') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Meta Description -->
                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>
                                        @error('meta_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <!-- Submit -->
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">Update Settings</button>
                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->


        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->


@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor5/41.3.1/ckeditor.min.js"></script>

    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>



    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error.stack);
            });


        $('.dropify').dropify();
    </script>
@endpush
