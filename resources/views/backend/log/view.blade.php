<div class="d-flex justify-content-between align-items-center">
    <div>
        <h4 class="mb-0">{{ $logDetails->log_name }}</h4>
        <p class="small mb-1"> {{ $logDetails->description }}</p>
    </div>
    <div>
        @if ( $logDetails->causer)
        <small class="bullet-badge-info rounded p-1">
            {{-- <img src="{{ getImage( $logDetails->causer?->image) }}" alt="" class="rounded-circle" width="14"> --}}
            {{ $logDetails->causer?->name }}</small>
        @endif
        <small class="bullet-badge-info rounded p-1">{{ ucfirst($logDetails->event) }}</small>
    </div>
</div>


<!-- Responsive Dashboard Table -->
<div class="table-responsive">
    <table class="table table-responsive-sm">
        <thead class="bg">
            <tr class="border-bottom">
                <th>{{ ___('label.attributes') }}</th>

                @if (!isset($logDetails->properties['attributes']) )
                <th>{{ ___('label.value') }}</th>

                @else
                <th>{{ ___('label.new') }}</th>
                <th>{{ ___('label.old') }}</th>

                @endif

            </tr>
        </thead>
        <tbody>

            @if (!isset($logDetails->properties['attributes']) && !isset($logDetails->properties['old']) )
            <x-nodata-found :colspan="3" />

            @elseif (!isset($logDetails->properties['attributes']) )
            @foreach (tap($logDetails->properties['old'], fn(&$properties) => ksort($properties) ) as $key => $value)
            <tr>
                <td>{{ ___("label.{$key}") }}</td>
                <td> {!! is_array($value) ? implode(', ', $value) : $value !!} </td>
            </tr>
            @endforeach

            @else
            @foreach (tap($logDetails->properties['attributes'], fn(&$properties) => ksort($properties) ) as $key => $value)
            <tr>
                <td>{{ ___("label.{$key}") }}</td>
                <td> {!! is_array($value) ? implode(', ', $value) : $value !!} </td>
                <td>{!! data_get($logDetails->properties['old'] ?? [], $key) !!}</td>
            </tr>
            @endforeach
            @endif


        </tbody>
    </table>
</div>
<!-- Responsive Dashboard Table -->
