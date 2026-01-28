@props(['coverage', 'depth' => 1])

@if (count($coverage->activeChild))
    @foreach ($coverage->activeChild as $child)
        <li data-id="{{ $child->id }}">
            @for ($i = 0; $i < $depth; $i++) &nbsp;&nbsp;&nbsp; @endfor
            &raquo;&nbsp; {{ $child->name }}
        </li>
        <x-coverage-child-ul :coverage="$child" :depth="$depth + 1" />
    @endforeach
@endif
