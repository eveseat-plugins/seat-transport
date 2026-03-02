@extends('web::layouts.grids.12')

@section('title', "Settings")
@section('page_header', "Settings")


@section('full')
    <div class="card">
        <div class="card-body">
            <h5 class="card-header">
                General Settings
            </h5>
            <div class="card-text my-3 mx-3">
                <form action="{{ route("transportplugin.saveSettings") }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="priceprovider">Price Provider</label>

                        @include("pricescore::utils.instance_selector",["id"=>"priceprovider","name"=>"priceprovider","instance_id"=>$price_provider])

                        <small class="text-muted">The source of the prices used to calculate the collateral. Manage price providers in the <a href="{{route('pricescore::settings')}}">price provider settings</a>.</small>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-header">
                {{ $route ? 'Edit' : 'Add' }} Route
            </h5>
            <div class="card-text my-3 mx-3">
                <form action="{{ route("transportplugin.saveRouteSettings") }}" method="POST">
                    @csrf
                    <div class="form-row">

                        <div class="form-group col-md-2">
                            <label for="source_location">Source</label>
                            <select class="form-control" id="source_location" name="source_location" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->station_id }}" {{ $route ? ($station->station_id == $route->source_location_id ? 'selected' : 'disabled') : null }} >
                                        {{ $station->name }}
                                    </option>
                                @endforeach
                                @foreach($structures as $structure)
                                    <option value="{{ $structure->structure_id }}" {{ $route ? ($structure->structure_id == $route->source_location_id ? 'selected' : 'disabled') : null }}>
                                        {{ $structure->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-2">
                            <label for="destination_location">Destination</label>
                            <select class="form-control" id="destination_location" name="destination_location" required>
                                @foreach($stations as $station)
                                    <option value="{{ $station->station_id }}" {{ $route ? ($station->station_id == $route->destination_location_id ? 'selected' : 'disabled') : null }} >
                                        {{ $station->name }}
                                    </option>
                                @endforeach
                                @foreach($structures as $structure)
                                    <option value="{{ $structure->structure_id }}" {{ $route ? ($structure->structure_id == $route->destination_location_id ? 'selected' : 'disabled') : null }}>
                                        {{ $structure->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-1">
                            <label for="collateral">Reward Collateral %</label>
                            <input type="number" class="form-control" id="collateral" name="collateral" required min="0" value="{{ $route ? $route->collateral_percentage : 10 }}">
                        </div>

                        <div class="form-group col-md-1">
                            <label for="iskm3">Reward isk/m<sup>3</sup></label>
                            <input type="number" class="form-control" id="iskm3" name="iskm3" required min="0" value="{{ $route ? $route->isk_per_m3 : 20 }}">
                        </div>

                        <div class="form-group col-md-1">
                            <label for="maxm3">Max m<sup>3</sup></label>
                            <input type="number" class="form-control" id="maxm3" name="maxm3" min="0" value="{{ $route ? $route->maxvolume : 360000 }}">
                        </div>

                        <div class="form-group col-md-1">
                            <label for="maxcollateral">Max Collateral</label>
                            <input type="number" class="form-control" id="maxcollateral" name="maxcollateral" min="0" value="{{ $route ? $route->max_collateral : null }}">
                        </div>

                        <div class="form-group col-md-1">
                            <label for="rushmarkup">Rush Markup %</label>
                            <input type="number" class="form-control" id="rushmarkup" name="rushmarkup" min="0" value="{{ $route ? $route->rush_markup : 20 }}">
                        </div>

                        <div class="form-group col-md-1">
                            <label for="baseprice">Base Price</label>
                            <input type="number" class="form-control" id="baseprice" name="baseprice" min="0" value="{{ $route ? $route->base_price : 0 }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="info_text">Info Text</label>
                        <textarea class="form-control" name="info_text" id="info_text" rows="5" placeholder="Write anything users might want to know when they see their estimate, for example how to submit the contract.">{{ $info_text }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary form-control">{{ $route ? 'Edit' : 'Add' }}</button>
                </form>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-header">
                Routes
            </h5>
            <div class="card-text my-3 mx-3">
                <table class="table table-hover mt-4">
                    <thead>
                        <tr>
                            <th>From</th>
                            <th>To</th>
                            <th>Reward Collateral %</th>
                            <th>Reward isk/m<sup>3</sup></th>
                            <th>Max Volume m<sup>3</sup></th>
                            <th>Max Collateral</th>
                            <th>Rush Markup %</th>
                            <th>Base Price</th>
                            <th>Info Text</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($routes as $route)
                            <tr>
                                <td>
                                    {{ $route->source_location()->name }}
                                </td>
                                <td>
                                    {{ $route->destination_location()->name }}
                                </td>
                                <td>
                                    {{ $route->collateral_percentage }}
                                </td>
                                <td>
                                    {{ $route->isk_per_m3 }}
                                </td>
                                <td>
                                    {{ $route->maxvolume }}
                                </td>
                                <td>
                                    {{ $route->max_collateral }}
                                </td>
                                <td>
                                    {{ $route->rush_markup }}
                                </td>
                                <td>
                                    {{ number_metric($route->base_price) }}
                                </td>
                                <td>
                                    {{$route->info_text}}
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route("transportplugin.settings") }}/{{$route->id}}" class="btn btn-primary">
                                            Edit
                                        </a>
                                        <form action="{{ route("transportplugin.deleteRoute") }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger confirmdelete">Delete</button>
                                            <input type="hidden" name="id" value="{{$route->id}}">
                                        </form>
                                    <div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@push("javascript")
    <script>
        $(document).ready( function () {
            $("#source_location").select2()
            $("#destination_location").select2()
            $('.data-table').DataTable();
        });
    </script>
@endpush