<form  id="form" class="row g-3" method="POST" action="{{$action}}" data-method="{{isset($model)?'PUT':'POST'}}">
    @isset($model)
        @method('PUT')
    @endisset
    @csrf
    <x-text-input label="name" name="name" value="{{isset($model)?$model->name:''}}"></x-text-input>

    <x-text-input label="phone" name="phone" value="{{isset($model)?$model->phone:''}}"></x-text-input>

    <input type="submit" class="btn btn-primary" id="submit" value="Save changes">
</form>
