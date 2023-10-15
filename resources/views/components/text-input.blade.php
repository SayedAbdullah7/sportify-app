<div class="col-12 x">
{{--    <label for="{{$name}}" class="form-label">{{$name}}</label>--}}
{{--    <div class="input-group">--}}
{{--        <span class="input-group-text bg-transparent"><i class='bx bxs-user'></i></span>--}}
{{--        <input type="text" class="form-control border-start-0" id="{{$name}}" name="{{$name}}" placeholder="" />--}}
{{--    </div>--}}

        <label for="{{$name}}" class="form-label text-capitalize">{{$name}}</label>
        <input type="text" class="form-control" name="{{$name}}" id="{{$name}}" value="{{$value??''}}">
        <div id="validationServer03Feedback" class="invalid-feedback">Please provide a valid city.</div>
</div>
