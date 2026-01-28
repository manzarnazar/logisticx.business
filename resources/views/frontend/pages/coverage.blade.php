@extends('frontend.master')

@section('title')
{{ ___('label.coverage') . " | " . settings('name') }}
@endsection

@section('main')

<!-- Start Coverage
		============================================= -->
<div class="coverage-area py-80 bg-dark">
    <div class="container">
        <div class="coverage-wpr">
            <div class="row g-5">
                <div class="col-xl-5">
                    <div class="section-title">
                        <span class="text-primary section-title-tagline border-2 border-start border-primary ps-2">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_title') }}</span>
                        <h2 class="hero-title-3 text-white">{!! customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'title') !!}</h2>
                        <p class="mb-4">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'short_description') }}</p>
                        <a href="#covarage-list" class="btn-1 two rounded-pill">{{ ___('label.see_all_area') }} <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="coverage-right">
                        <img src="{{ data_get(customSection(\Modules\Section\Enums\Type::COVERAGE_AREA,'bg_image'), 'original') }}" alt="no image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Coverage -->

<!-- Start Coverage Area List
		============================================= -->
<div id="covarage-list">
    <div class="covarage-list-3 py-80">
        <div class="container">

            <div class="charge-table p-4 p-lg-5 shadow rounded">
                {{-- Filtering --}}
                <form method="GET" action="{{ route('frontend.coverage') }}" id="coverageSearchForm">

                    <div class="row g-4 align-items-center mb-4">
                        <div class="col-md-4">
                            <select name="type" onchange="this.form.submit()" class="form-select shadow-none custom-dropdown px-4 py-3">
                            <option value="">{{ ___('label.all_types') }}</option>
                            <option value="Inside City" {{ request('type') == 'Inside City' ? 'selected' : '' }}>{{ ___('label.inside_city') }}</option>
                            <option value="Sub City" {{ request('type') == 'Sub City' ? 'selected' : '' }}>{{ ___('label.sub_city') }}</option>
                            <option value="Outside City" {{ request('type') == 'Outside City' ? 'selected' : '' }}>{{ ___('label.outside_city') }}</option>
                            </select>

                            {{-- <div class="custom-select w-100">
                                <div class="select-box">
                                    <span class="selected-text">All Types</span>
                                </div>
                                <ul class="options">
                                    <li>Inside City</li>
                                    <li>Sub City</li>
                                    <li>Outside City</li>
                                </ul>
                            </div> --}}
                        </div>

                        <div class="col-md-4">
                            <input type="text" name="keyword" id="keywordInput" value="{{ request('keyword') }}" class="form-control shadow-none" placeholder="{{ ___('placeholder.Area_or_district') }}">
                        </div>
                    </div>

                </form>

                <h4 class="fw-semibold mb-3">{{ customSection(\Modules\Section\Enums\Type::COVERAGE_AREA, 'coverage_list_title') }}</h4>

                <div class="table-responsive mb-0">
                    <table class="table table-bordered table-group-divider table-striped align-middle">
                        <thead class="">
                            <tr>
                                <th class="">{{ ___('label.from_area') }}</th>
                                <th class="">{{ ___('label.destination_area') }}</th>
                                <th class="">{{ ___('label.area_type') }}</th>
                                <th class="">{{ ___('label.kg_1_2_3') }}</th>
                                <th class="">{{ ___('label.mobile_1_2_3') }}</th>
                                <th class="">{{ ___('label.cod_charge') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($coverages as $item)

                            <tr>
                                <td>{{ $item['district'] }}</td>
                                <td>{{ $item['thana_area'] }}</td>
                                <td>{{ $item['type'] }}</td>
                                @foreach($item['charges'] as $charge)

                                <th class="fw-normal text-dark">{{$charge[0]}}-{{$charge[1]}}-{{$charge[2]}}{{ settings('currency') }}</th>
                                @endforeach
                                <th class="fw-normal text-dark">{{$item['cod']}}%</th>
                            </tr>

                            @endforeach

                        </tbody>
                    </table>
                </div>

                <div class="row align-items-center">
                    <div class="col-md-12 ">
                        <div class="pagination-custom mt-lg-5 mt-4">
                            {{ $coverages->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Coverage Area List -->
@endsection


@push('scripts')
<script src="{{ asset('frontend/js/areaListSearch.js') }}"></script>
@endpush
