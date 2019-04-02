<div class="form-group {!! !$errors->has($label) ?: 'has-error' !!}" >

    <label for="{{$id}}" class="col-sm-2 control-label">{{$label}}</label>
    <div class="col-sm-6">
        @include('admin::form.error')

        <div class="controls" id="select2-wrapper-{{$name}}">
            <select name="{{$name}}" id="{{$name}}-select2" class="form-control input-block" data-value="{{ old($column, $value) }}">
                <option value="{{ old($column, $value) }}" selected>{{ old($column, $value) }}</option>
            </select>
        </div>
        @include('admin::form.help-block')
    </div>
</div>