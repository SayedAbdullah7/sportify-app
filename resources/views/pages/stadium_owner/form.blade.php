<link rel="stylesheet" href="{{asset('assets/plugins/dropzone/dropzone.min.css')}}" type="text/css"/>
<link href="{{asset('assets/plugins/fancy-file-uploader/fancy_fileupload.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/plugins/select2/css/select2-bootstrap4.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/plugins/VenoBox/venobox.min.css')}}" rel="stylesheet"/>

<form id="form" class="row g-3" method="POST" action="{{$action}}" data-method="{{isset($model)?'PUT':'POST'}}">
    @isset($model)
        @method('PUT')
    @endisset
    @csrf
    <x-forms.text-input label="name" name="name" value="{{isset($model)?$model->name:''}}"></x-forms.text-input>

    <x-forms.text-input label="phone" name="phone" value="{{isset($model)?$model->phone:''}}"></x-forms.text-input>
    <x-forms.email-input label="email" name="email" value="{{isset($model)?$model->email:''}}"></x-forms.email-input>

    <x-forms.text-input label="stadium name" name="stadium_name" value="{{isset($model)?$model->stadium->name:''}}"></x-forms.text-input>
    <x-forms.text-input label="location link" name="location_link" value="{{isset($model)?$model->stadium->location_link:''}}"></x-forms.text-input>
    <x-forms.text-input label="longitude" name="longitude" value="{{isset($model)?$model->stadium->longitude:''}}"></x-forms.text-input>
    <x-forms.text-input label="latitude" name="latitude" value="{{isset($model)?$model->stadium->latitude:''}}"></x-forms.text-input>


        <x-forms.select label="stadium type" name="stadia_type_id"
                    :options="\App\Models\StadiumType::pluck('id','name')->toArray()"
                    old="{{isset($model)?$model->stadium->stadium_type_id:''}}"></x-forms.select>
    <x-forms.multi-select label="sports" name="sports[]" :options="\App\Models\Sport::pluck('name','id')->toArray()"
                          :old="isset($model)?$model->stadium->sports->pluck('id')->toArray():[]">
    </x-forms.multi-select>

    <!--begin::Input group-->
    <div class="fv-row">
        <!--begin::Dropzone-->
        <div class="dropzone" id="dropzone">
            <!--begin::Message-->
            <div class="dz-message needsclick">
                <i class="ki-duotone ki-file-up fs-3x text-primary"><span class="path1"></span><span
                        class="path2"></span></i>

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
    <div id="image_inputs">
    </div>
    @if(isset($model) && $model->stadium)
        <div class="row">

            @foreach($model->stadium->getMedia() as $image)
                <div class="col-6 ">
                    <div class="card h-100 m-1">
                        <a class="my-image-links" data-gall="gallery01"
                           href="{{asset('/storage/'.$image->id.'/'.$image->file_name)}}">
                            <img class="img-thumbnail img-fluid" src="{{asset('/storage/'.$image->id.'/'.$image->file_name)}}"></a>
                    </div>
                </div>


            @endforeach
        </div>
    @endif

    <input type="submit" class="btn btn-primary" id="submit" value="Save changes">
</form>



<!-- resources/views/your_form.blade.php -->
{{--<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>--}}
<script src="{{asset('assets/plugins/dropzone/dropzone.min.js')}}"></script>
<script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>
<script src="{{asset('assets/plugins/VenoBox/venobox.min.js')}}"></script>
<script>
    $(document).ready(function () {
        new VenoBox({
            selector: '.my-image-links',
            numeration: true,
            infinigall: true,
            share: true,
            spinner: 'rotating-plane'
        });
        $('.multiple-select').select2({
            dropdownParent: $("#modalForm .modal-body"),
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        // Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone("#dropzone", {
            url: "{{ route('upload-image') }}",
            paramName: "image",
            maxFiles: 20, // Allow up to 20 files
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            init: function () {
                this.on('success', function (file, response) {
                    // Create a hidden input for each uploaded image
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'image[]';
                    input.value = response.filename;
                    document.getElementById('image_inputs').appendChild(input);
                });
            },
            error: function (xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
            }
        });
    });
</script>
