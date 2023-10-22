<link rel="stylesheet" href="{{asset('assets/plugins/dropzone/dropzone.min.css')}}" type="text/css" />
<link href="assets/plugins/fancy-file-uploader/fancy_fileupload.css" rel="stylesheet" />
0<form  id="form" class="row g-3" method="POST" action="{{$action}}" data-method="{{isset($model)?'PUT':'POST'}}">
    @isset($model)
        @method('PUT')
    @endisset
    @csrf
    <x-forms.text-input label="name" name="name" value="{{isset($model)?$model->name:''}}"></x-forms.text-input>

    <x-forms.text-input label="phone" name="phone" value="{{isset($model)?$model->phone:''}}"></x-forms.text-input>
    <x-forms.text-input label="email" name="email" value="{{isset($model)?$model->email:''}}"></x-forms.text-input>
    <x-forms.text-input label="stadium name" name="stadium_name" value="{{isset($model)?$model->stadium_name:''}}"></x-forms.text-input>
    <x-forms.select label="stadium type" name="stadium_type" :options="\App\Models\StadiumType::pluck('id','name')->toArray()" old="{{isset($model)?$model->stadium_type:''}}"></x-forms.select>
{{--    <x-forms.text-input label="sports" name="sports" value="{{isset($model)?$model->sports:''}}"></x-forms.text-input>--}}
{{--        <x-select label="section" :options="\App\Models\Category::pluck('id','name')->toArray()" old="{{isset($model)?$model->section_id:''}}" name="section_id" ></x-select>--}}

        <!--begin::Input group-->
        <div class="fv-row">
            <!--begin::Dropzone-->
            <div class="dropzone" id="dropzone">
                <!--begin::Message-->
                <div class="dz-message needsclick">
                    <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span class="path2"></span></i>

                    <!--begin::Info-->
                    <div class="ms-4">
                        <h3 class="fs-5 fw-bold text-gray-900 mb-1">Drop files here or click to upload.</h3>
                        <span class="fs-7 fw-semibold text-gray-400">Upload up to 20 images</span>
                    </div>
                    <!--end::Info-->
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Fancy File Upload</h6>
            <hr/>
            <div class="card">
                <div class="card-body">
                    <input id="fancy-file-upload" type="file" name="files" accept=".jpg, .png, image/jpeg, image/png" multiple>
                </div>
            </div>
        </div>

        <div id="image_inputs">
    </div>

    <input type="submit" class="btn btn-primary" id="submit" value="Save changes">
</form>
<!-- resources/views/your_form.blade.php -->
{{--<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>--}}
<script src="{{asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('upload-image') }}",
            paramName: "image",
            maxFiles: 20, // Allow up to 20 files
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function() {
                this.on('success', function(file, response) {
                    // Create a hidden input for each uploaded image
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'image[]';
                    input.value = response.filename;
                    document.getElementById('image_inputs').appendChild(input);
                });
            },
            error: function(xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
            }
        });
    });
</script>
