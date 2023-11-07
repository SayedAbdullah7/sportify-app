<form id="form" class="row g-3" method="POST" action="{{$action}}" data-method="{{isset($model)?'PUT':'POST'}}">
    @isset($model)
        @method('PUT')
    @endisset
    @csrf
    {{--    <x-input-text></x-input-text>--}}
    <x-forms.text-input label="name" name="name" value="{{isset($model)?$model->name:''}}"></x-forms.text-input>
    <x-forms.text-input label="username" name="username" value="{{isset($model)?$model->username:''}}"></x-forms.text-input>
    <x-forms.text-input label="password" name="password" value=""></x-forms.text-input>
    <x-forms.text-input label="password confirmation" name="password_confirmation" value=""></x-forms.text-input>

        <input type="submit" class="btn btn-primary" id="submit" value="Save changes">

</form>
