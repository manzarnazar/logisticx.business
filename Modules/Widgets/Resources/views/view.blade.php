
@if($widget->value)
<table class="table table-responsive border-top-none">
    <tbody>
        @php $i=0; @endphp
        @foreach ($widget->value as $key => $value )
            @switch($key)
                @case('type')
                    <tr>
                        <td>{{ ___($key) }}</td>
                        <td> {!! getwidgettype($value) !!}</td>
                    </tr>
                @break
                @case('image')
                    <tr>
                        <td>{{ ___($key) }}</td>
                        <td> <img src="{{ widgetImage($value) }}" style="width:100px;object-fit:contain"/></td>
                    </tr>
                @break
                @default
                    <tr>
                        <td>{{ ___($key) }}</td>
                        <td> {{ $value }}</td>
                    </tr>
                @break
            @endswitch
        @endforeach
    </tbody>
</table>
@else
{{ ___('data_not_found')}}
@endif
