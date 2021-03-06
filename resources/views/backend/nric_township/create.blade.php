@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.nric_township.management') . ' | ' . trans('labels.backend.nric_township.create'))

@section('after-styles')
      {{ Html::style("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css") }}
@stop

@section('page-header')
    <h1>
        {{ trans('labels.backend.nric_township.management') }}
        <small>{{ trans('labels.backend.nric_township.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.nric_township.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.nric_township.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.nric_township.includes.partials.nric-township-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="row">
                <div class="col-md-12">
                    
                    <div class="panel panel-primary" data-collapsed="0">
                    
                        <div class="panel-heading">
                            <div class="panel-title">
                               
                            </div>
                        </div>
                        
                        <div class="panel-body">
                            
                            <div class="form-group">
                                 {{ Form::label('township', trans('validation.attributes.backend.nric_township.township'), ['class' => 'col-lg-2 control-label']) }}
                                
                                <div class="col-lg-10">
                                   {{ Form::text('township', null, ['class' => 'form-control','autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.nric_township.township')]) }}
                                </div>
                            </div>

                            <div class="form-group">
                                {{ Form::label('nric_code_id', trans('validation.attributes.backend.nric_township.nric_code'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    <select class='form-control' name='nric_code_id'>
                                        <option>Select</option>
                                        @foreach($nric_codes as $nric_code)
                                            @if(old('nric_code') == $nric_code->id)
                                                <option value="{{ $nric_code->id }}" selected>{{ $nric_code->nric_code }}</option>
                                            @else
                                                <option value="{{ $nric_code->id }}"> {{ $nric_code->nric_code }} </option>
                                            @endif
                                        @endforeach
                                    </select><br>
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group">
                                {{ Form::label('short_name', trans('validation.attributes.backend.nric_township.short_name'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('short_name', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.nric_township.short_name')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group">
                                {{ Form::label('serial_no', trans('validation.attributes.backend.nric_township.serial_no'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('serial_no', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.nric_township.serial_no')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->
                            
                        </div>
                    
                    </div>
                
                </div>
            </div>

        </div><!--box-->

        <div class="box box-info">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.nric_township.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
                </div><!--pull-left-->

                <div class="pull-right">
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-success btn-xs']) }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ Form::close() }}
@endsection

@section('after-scripts')
    {{ Html::script('js/backend/access/users/script.js') }}
    {{ Html::script("https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js") }}
    <script type="text/javascript">
        
        $('.select2').select2({ 
            placeholder:"Please Select"
        });
    </script>
@endsection
