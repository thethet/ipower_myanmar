@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.community.management') . ' | ' . trans('labels.backend.community.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.community.management') }}
        <small>{{ trans('labels.backend.community.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($community, ['route' => ['admin.communities.update', $community], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.community.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.communities.includes.partials.community-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('community_name', trans('validation.attributes.backend.community.community_name'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('community_name', null, ['class' => 'form-control','autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.community.community_name')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('village_tract_id', trans('validation.attributes.backend.community.district'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <select class='form-control select2' name='village_tract_id'>
                            <option></option>
                            @foreach($villages as $village)
                                @if($village->id == $community->village_tract_id)
                                    <option value="{{ $village->id }}" selected>{{ $village->village_name }}</option>
                                @else
                                    <option value="{{ $village->id }}"> {{ $village->village_name }} </option>
                                @endif
                            @endforeach
                        </select><br>
                    </div><!--col-lg-10-->
                </div> 


                <div class="form-group">
                    {{ Form::label('community_code', trans('validation.attributes.backend.community.community_code'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('community_code', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.community.community_code')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('description', trans('validation.attributes.backend.community.description'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::textarea('description', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.community.description')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.communities.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
@endsection