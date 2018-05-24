@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.transformer.management') . ' | ' . trans('labels.backend.transformer.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.transformer.management') }}
        <small>{{ trans('labels.backend.transformer.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($transformer, ['route' => ['admin.transformer.update', $transformer], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH']) }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.transformer.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.transformer.includes.partials.transformer-header-buttons')
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
                                {{ Form::label('transformer_name', trans('validation.attributes.backend.transformer.transformer_name'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('transformer_name', null, ['class' => 'form-control','autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.transformer.transformer_name')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group">
                                {{ Form::label('street_id', trans('validation.attributes.backend.transformer.street'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    <select class='form-control' name='street_id'>
                                        <option value="">Select</option>
                                         @foreach($streets as $street)
                                            @if($street->id == $transformer->street_id)
                                                <option value="{{ $street->id }}" selected>{{ $street->street_name }}</option>
                                            @else
                                                <option value="{{ $street->id }}"> {{ $street->street_name }} </option>
                                            @endif
                                        @endforeach
                                    </select><br>
                                </div><!--col-lg-10-->
                            </div> 

                            <div class="form-group">
                                {{ Form::label('qrcode', trans('validation.attributes.backend.transformer.qrcode'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('qrcode', null, ['class' => 'form-control', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.transformer.qrcode')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group">
                                {{ Form::label('latitude', trans('validation.attributes.backend.region.latitude'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('latitude', null, ['class' => 'form-control','id' => 'input-latitude', 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.region.latitude')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group">
                                {{ Form::label('longitude', trans('validation.attributes.backend.region.longitude'), ['class' => 'col-lg-2 control-label']) }}

                                <div class="col-lg-10">
                                    {{ Form::text('longitude', null, ['class' => 'form-control','id' => 'input-longitude' , 'autofocus' => 'autofocus', 'placeholder' => trans('validation.attributes.backend.region.longitude')]) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <input id="pac-input" class="controls" type="text" placeholder="Search Place">

                            <div class="form-group">
                                <div class="col-lg-2"></div>
                                <div class="col-lg-10">
                                    <div id="map-canvas"
                                         style="width:97%;height:400px;"></div>
                                    <div id="ajax_msg"></div>
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                    </div>
                
                </div>
            </div>

        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    {{ link_to_route('admin.transformer.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-xs']) }}
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

    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.app_setting.google_map') }}&libraries=weather,geometry,visualization,places,drawing&callback=map_pos"
            async defer></script>

    <script>
        function map_pos() {
            if('{{ $transformer->latitude }}'  && '{{ $transformer->longitude }}' ) {
                initMap({{ $transformer->latitude }},{{ $transformer->longitude }})
            }else{
                initMap(16.798703652839684, 96.14947007373053 )
            }
        }

        function initMap(mylat, mylong) {
            var mapOptions = {
                center: {lat: mylat, lng: mylong},
                zoom: 13
            };
            var map = new google.maps.Map(document.getElementById('map-canvas'),
                    mapOptions);

            var marker_position = {lat: mylat, lng: mylong};
            var input = /** @type {HTMLInputElement} */(
                    document.getElementById('pac-input'));

            var types = document.getElementById('type-selector');
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.bindTo('bounds', map);

            var infowindow = new google.maps.InfoWindow();
            var marker = new google.maps.Marker({
                position: marker_position,
                draggable: true,
                map: map,
                anchorPoint: new google.maps.Point(0, -29)
            });


            google.maps.event.addListener(marker, "mouseup", function (event) {
                $('#input-latitude').val(this.position.lat());
                $('#input-longitude').val(this.position.lng());
            });

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                infowindow.close();
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }

                // If the place has a geometry, then present it on a map.
                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setIcon(/** @type {google.maps.Icon} */({
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(35, 35)
                }));

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);

                $('#input-latitude').val(place.geometry.location.lat());
                $('#input-longitude').val(place.geometry.location.lng());

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }

                $('input[name=address]').val(place.formatted_address);

                infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                infowindow.open(map, marker);
            });


            google.maps.event.addListener(marker, 'dragend', function () {

                $('#input-latitude').val(place.geometry.location.lat());
                $('#input-longitude').val(place.geometry.location.lng());

            });

        }

        if ($('#map-canvas').length != 0) {
            google.maps.event.addDomListener(window, 'load', initMap);
        }
    </script>
@endsection