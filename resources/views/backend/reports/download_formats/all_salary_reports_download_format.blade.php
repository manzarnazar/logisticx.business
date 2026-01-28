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
                    <th>{{ ___('reports.user_details') }}</th>
                    <th>{{ ___('label.month') }}</th>
                    <th>{{ ___('reports.salary') }}</th>
                    <th>{{ ___('reports.paid_amount') }}</th>
                    <th>{{ ___('label.status') }}</th>

            </thead>
            <tbody>

                @foreach ($salaries as $key => $salary)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                        <span> {{ @$salary->user->name }}</span><br>
                        <span> {{ @$salary->user->email }}</span><br>
                        <span> {{ @$salary->user->mobile }}</span><br>
                    </td>
                    <td>{{ \Carbon\Carbon::createFromFormat('Y-m', @$salary->month)->format('M Y') }}</td>
                    {{-- <td>{{ @$salary->month }}</td> --}}
                    <td> {{ settings('currency') }}{{ @$salary->amount }}</td>

                    @if ($salary->paidSalary && $salary->paidSalary->isNotEmpty())
                    <td>{{ $salary->paidSalary->first()->amount }}</td>
                    @else
                    <td> Not paid Yet </td>
                    @endif

                    <td> {!! $salary->MyStatus !!} </td>

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
