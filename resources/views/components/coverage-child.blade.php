@props(['coverage','name','old'=>0, 'depth'=>1 ])

@if(count($coverage->activeChild) )

@foreach ($coverage->activeChild as $coverage )


<option value="{{ $coverage->id }}" @selected(old($name,$old)==$coverage->id) > @for($s = 0; $s < $depth; $s++) &nbsp;&nbsp;&nbsp; @endfor &raquo;&nbsp; {{ $coverage->name }} </option>

        <x-coverage-child :coverage="$coverage" :name="$name" :old="$old" :depth="$depth+1" />
        @endforeach
        @endif
