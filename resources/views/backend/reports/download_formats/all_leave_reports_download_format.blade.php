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
                    <th>{{ ___('#') }}</th>
                    <th scope="col">{{ ___('label.name') }}</th>
                    <th scope="col">{{ ___('hr_manage.leave_type') }}</th>
                    <th scope="col">{{ ___('label.date') }}</th>
                    <th scope="col">{{ ___('hr_manage.days') }}</th>
                    <th scope="col">{{ ___('hr_manage.available_days') }}</th>
                    <th scope="col">{{ ___('hr_manage.request_status') }}</th>

            </thead>
            <tbody>
                @foreach ($leaves as $leave)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $leave->user->name }}</td>
                    <td>{{ $leave->leaveTypes->name }}</td>
                    <td>{{ dateFormat($leave->from_date) }} - {{ dateFormat($leave->to_date) }}</td>
                    <td>{{ $leave->days }}</td>
                    <td>{{ $leave->AvailableDays }}</td>
                    <td>{!! $leave->LeaveRequestStatus !!}</td>
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
