<span class="dropdown select2-filter" id="filter_select_{{$column}}_span">
    <form action="{{$uri}}" pjax-container style="display: inline-block;">
        <a href="javascript:void(0);" class="dropdown-toggle " data-toggle="dropdown" aria-expanded="true">
            <i class="fa fa-filter"></i>
        </a>
        <ul class="dropdown-menu" role="menu" style="padding: 10px;box-shadow: 0 2px 3px 0 rgba(0,0,0,.2);left: -70px;border-radius: 0;">
            <li>
                <select type="text" class="form-control input-sm column-filter-{{$column}}" name="{{$column}}" id="filter_select2_{{$column}}" value="{{request()->get($column)}}" style="width: 100%" autocomplete="off"/>
            </li>
            <li class="divider">
            </li><li class="text-right">
                <button class="btn btn-search btn-sm btn-primary btn-flat column-filter-submit pull-left" data-loading-text="搜索..."><i class="fa fa-search"></i>&nbsp;&nbsp;搜索</button>
                <button class="btn btn-sm btn-default btn-flat column-filter-all" data-loading-text="..."><i class="fa fa-undo"></i></button>
            </li>
        </ul>
    </form>
</span>
