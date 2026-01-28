<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{___('reports.report')}}</title>
    <style>
        main {
            page-break-inside: avoid;
        }

        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #f0f0f0;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #000000;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .bg {
            background-color: #4CAF50;
            color: white;
        }

        .bg th {
            font-weight: bold;
        }

        . {
            overflow-x: auto;
        }

    </style>
</head>
<body>
    <main>
        <h1>{{___('reports.percelfly-Reports')}} </h1>
    </main>

    <section>

        <table class="table    ">
            @php $i=1; @endphp

            <thead class="bg">
                <tr>
                    {{-- <a href="#" style = "float:right">Download All</a> --}}
                    <th>{{ ___('#') }}</th>
                    <th scope="col">{{ ___('label.name') }}</th>
                    <th scope="col">{{ ___('label.date') }}</th>
                    <th scope="col">{{ ___('hr_manage.check_in') }}</th>
                    <th scope="col">{{ ___('hr_manage.check_out') }}</th>
                    <th scope="col">{{ ___('label.department') }}</th>
                    <th scope="col">{{ ___('label.designation') }}</th>
                    <th scope="col">{{ ___('label.status') }}</th>

            </thead>
            <tbody>
                {{-- @dd($attendances) --}}
                @foreach ($attendances as $attendance )
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ @$attendance->user->name }}</td>
                    <td>{{ dateFormat(@$attendance->date) }}</td>
                    <td>{{ $attendance->check_in ? date('h:i:s A', strtotime($attendance->check_in)) : '' }} </td>
                    <td>{{ $attendance->check_out ? date('h:i:s A', strtotime($attendance->check_out)) : '' }} </td>
                    <td>{{ @$attendance->user->department->title }}</td>
                    <td>{{ @$attendance->user->designation->title }}</td>
                    <td>{!! $attendance->attendance_type !!}</td>
                </tr>
                @endforeach
            </tbody>

        </table>


    </section>

    <footer>
        <p>{{ settings('copyright') }}</p>
    </footer>
</body>
</html>
