<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}" >

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="col-sm-6">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('admin::form.error')

        <div class="controls" id="select2-wrapper-{{$name}}">
            <input name="{{$name}}" id="{{$name}}-select2" class="form-control input-sm input-block"/>
        </div>
        @include('admin::form.help-block')
    </div>
</div>