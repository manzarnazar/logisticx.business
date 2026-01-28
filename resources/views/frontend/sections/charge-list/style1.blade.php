<div class="charge-area {{ implode(' ', $widget->section_padding) }}"
    @if($widget->background === 'bg_color') data-background-color="{{ $widget->bg_color }}" 
        @elseif($widget->background === 'bg_image') data-background="{{ getImage($widget->upload) }}" 
    @endif> 

    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">

                @if( !request()->is('charges') )
                <div class="section-title text-center mb-50">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ ___('label.Charge') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CHARGE_LIST, 'title') !!}</h2>
                    <p>{{ customSection(\Modules\Section\Enums\Type::CHARGE_LIST, 'short_description') }}</p>
                </div>
                @endif

                @if( request()->is('charges') )
                <div class="section-title text-center mb-50">
                    <span class="text-primary section-title-tagline border-2 border-primary border-start ps-2">{{ ___('label.Charge') }}</span>
                    <h2 class="hero-title-3">{!! customSection(\Modules\Section\Enums\Type::CHARGE_LIST, 'title') !!}</h2>
                    <p>{{ customSection(\Modules\Section\Enums\Type::CHARGE_LIST, 'description') }}</p>
                </div>
                @endif

            </div>
        </div>

        <div class="charge-wpr">
            <ul class="nav nav-pills rounded shadow-sm" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill active" id="pills-inside_city-tab" data-bs-toggle="pill" data-bs-target="#pills-inside_city" type="button" role="tab" aria-controls="pills-inside_city" aria-selected="true">
                        {{ ___('charges.inside_city')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-outside_city-tab" data-bs-toggle="pill" data-bs-target="#pills-outside_city" type="button" role="tab" aria-controls="pills-outside_city" aria-selected="false">
                        {{ ___('charges.outside_city')}}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-subcity-tab" data-bs-toggle="pill" data-bs-target="#pills-subcity" type="button" role="tab" aria-controls="pills-subcity" aria-selected="false">
                        {{ ___('charges.sub_city')}}
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-inside_city" role="tabpanel" aria-labelledby="pills-inside_city-tab">
                    <div class="charge-table rounded p-4 p-lg-5 shadow table-responsive">
                        <h4 class="fw-semibold mb-3">Charge List</h4>
                        <table class="table table-bordered table-group-divider table-striped align-middle mb-0">
                            <thead class="bg">
                                <tr>
                                    <th scope="col">{{ ___('charges.product_category') }}</th>
                                    <th scope="col">{{ ___('charges.service_type') }}</th>
                                    <th scope="col">{{ ___('charges.delivery_time') }}</th>
                                    <th scope="col">{{ ___('charges.charges') }}</th>
                                    <th scope="col">{{ ___('charges.additional_charge') }}</th>
                                    <th scope="col">{{ ___('charges.return_charge') }}</th>
                                    <th scope="col">{{ ___('label.cod') }} %</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($insideCityCharges as $charge )
                                <tr>
                                    <td>{{ $charge->productCategory->name }}</td>
                                    <td>{{ $charge->serviceType->name }}</td>
                                    <td>{{ $charge->delivery_time }} hour</td>
                                    <td>{{ settings('currency') . ' ' . $charge->charge }}</td>
                                    <td>{{ settings('currency') . ' ' . $charge->additional_charge }}</td>
                                    <td>{{ $charge->return_charge }}%</td>
                                    <td>{{ settings('cod_inside_city') }}%</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-outside_city" role="tabpanel" aria-labelledby="pills-outside_city-tab">
                    <div class="charge-table rounded p-4 p-lg-5 shadow table-responsive">
                        <h4 class="fw-semibold mb-3">Charge List</h4>
                        <table class="table table-bordered table-group-divider table-striped align-middle mb-0">
                            <thead class="bg">
                                <tr>
                                    <th scope="col">{{ ___('charges.product_category') }}</th>
                                    <th scope="col">{{ ___('charges.service_type') }}</th>
                                    <th scope="col">{{ ___('charges.delivery_time') }}</th>
                                    <th scope="col">{{ ___('charges.charges') }}</th>
                                    <th scope="col">{{ ___('charges.additional_charge') }}</th>
                                    <th scope="col">{{ ___('charges.return_charge') }}</th>
                                    <th scope="col">{{ ___('label.cod') }} %</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($outsideCityCharges as $charge )
                                <tr>
                                    <td>{{$charge->productCategory->name}}</td>
                                    <td>{{$charge->serviceType->name}}</td>
                                    <td>{{$charge->delivery_time}} hour</td>
                                    <td>{{ @settings('currency') . ' ' . $charge->charge}}</td>
                                    <td>{{ @settings('currency') . ' ' . $charge->additional_charge}}</td>
                                    <td>{{ $charge->return_charge }}%</td>
                                    <td>{{ settings('cod_outside_city') }}%</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="pills-subcity" role="tabpanel" aria-labelledby="pills-subcity-tab">
                    <div class="charge-table rounded p-4 p-lg-5 shadow table-responsive">
                        <h4 class="fw-semibold mb-3">Charge List</h4>
                        <table class="table table-bordered table-group-divider table-striped align-middle mb-0">
                            <thead class="bg">
                                <tr>
                                    <th scope="col">{{ ___('charges.product_category') }}</th>
                                    <th scope="col">{{ ___('charges.service_type') }}</th>
                                    <th scope="col">{{ ___('charges.delivery_time') }}</th>
                                    <th scope="col">{{ ___('charges.charges') }}</th>
                                    <th scope="col">{{ ___('charges.additional_charge') }}</th>
                                    <th scope="col">{{ ___('charges.return_charge') }}</th>
                                    <th scope="col">{{ ___('label.cod') }} %</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($subCityCharges as $charge )
                                <tr>
                                    <td>{{$charge->productCategory->name}}</td>
                                    <td>{{$charge->serviceType->name}}</td>
                                    <td>{{$charge->delivery_time}} hour</td>
                                    <td>{{ @settings('currency') . ' ' . $charge->charge}}</td>
                                    <td>{{ @settings('currency') . ' ' . $charge->additional_charge}}</td>
                                    <td>{{$charge->return_charge}}%</td>
                                    <td>{{ settings('cod_sub_city') }}%</td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
