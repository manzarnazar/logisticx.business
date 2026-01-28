<div class="table-responsive">
    <table class="table">
        <thead class="bg">
            <tr>
                <th scope="col">{{ ___('label.id') }}</th>
                <th scope="col">{{ ___('label.name') }}</th>
                <th scope="col">{{ ___('hr_manage.check_in') }}</th>
                <th scope="col">{{ ___('hr_manage.check_out') }}</th>
                <th scope="col">{{ ___('label.type') }}</th>
                <th scope="col">{{ ___('label.note') }}</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($users as $key => $user )

            <input type="hidden" name="user[{{ $key }}][id]" value="{{ $user->id }}">

            @php
            $attendance=Modules\Attendance\Entities\Attendance::where('user_id', $user->id)->where('date',@$date)->first();
            @endphp


            <tr>
                <td>{{ $key + 1 }} </td>
                <td>{{ $user->name }}</td>
                <td> <input type="time" class="form-control input-style-1" name="user[{{ $key }}][check_in]" value="{{ @$attendance['check_in'] }}" placeholder="00:00" required> </td>
                <td> <input type="time" class="form-control input-style-1" name="user[{{ $key }}][check_out]" value="{{ @$attendance->check_out }}" placeholder="00:00"> </td>
                <td>
                    <select name="user[{{ $key }}][attendance_type]" class="form-control input-style-1" required>
                        @foreach(config('attendance.type') as $typeKey => $option)
                        <option value="{{ $typeKey }}" @selected(@$attendance->type == $typeKey) >{{ ___('label.'.$option) }}</option>
                        @endforeach
                    </select>
                </td>
                <td> <input type="text" class="form-control input-style-1" name="user[{{ $key }}][note]" value="{{ @$attendance->note  }}" placeholder="Note"> </td>
            </tr>

            @empty
            <tr>
                <td>no data</td>
            </tr>
            @endforelse

        </tbody>
    </table>
</div>


<script type="text/javascript">
    // $('input[type="time"]').flatpickr({
    //     enableTime: true
    //     , noCalendar: true
    //     , dateFormat: "H:i:S"
    //     , altInput: true
    //     , altFormat: "h:i K"
    // });

</script>
