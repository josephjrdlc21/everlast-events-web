<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title></title>
    </head>
    <style>
        .text-uppercase {
            text-transform: uppercase;
        }

        .text-center {
            text-align: center;
        }

        .text-right{
            text-align: right;
        }

        .lh1 {
            line-height: 2px;
        }

        .fs14 {
            font-size: 14px;
        }

        table,
        td,
        th {
            border: 1px solid;
        }

        table {
            page-break-inside: auto
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto
        }

        thead {
            display: table-header-group
        }

        tfoot {
            display: table-footer-group
        }

        @page {
            margin: 0cm 0cm;
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 2.1cm;
            margin-left: 1cm;
            margin-right: 1cm;
            margin-bottom: 1cm;
            font-family: Arial, Helvetica, sans-serif;

        }

        /** Define the header rules **/
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border-none {
            border: none;
        }

        .border-white{
            border-color: white;
        }
    </style>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" class="border-white">
            <tbody>
                <tr class="border-none">
                    <td class="text-center border-none">
                        <p class="lh1 fs14 text-center"><b>Transactions</b></p>
                        <p class="lh1 fs14 text-center"><b>{{Carbon::now()->format('F d, Y g:i A')}}</b></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center text-uppercase fs14">Booking ID</th>
                    <th class="text-center text-uppercase fs14">Event</th>
                    <th class="text-center text-uppercase fs14">Customer</th>
                    <th class="text-center text-uppercase fs14">Processor</th>
                    <th class="text-center text-right text-uppercase fs14">Price</th>
                    <th class="text-center text-uppercase fs14">Status</th>
                    <th class="text-center text-uppercase fs14">Payment</th>
                    <th class="text-center text-uppercase fs14">Date Booked</th>
                </tr>
            </thead>
            <tbody>
                @forelse($record as $index => $transaction)
                    <tr>
                        <td>{{$transaction->code ?? ''}}</td>
                        <td>{{$transaction->event->name ?? ''}}</td>
                        <td>{{$transaction->user->name ?? ''}}</td>
                        <td>{{$transaction->processor->name ?? ''}}</td>
                        <td class="text-right">₱ {{$transaction->event->price ?? ''}}</td>
                        <td>{{$transaction->status ?? ''}}</td>
                        <td>{{$transaction->payment_status ?? ''}}</td>
                        <td>{{Carbon::parse($transaction->created_at)->format('m/d/Y h:i A') ?? ''}}</td>
                    </tr>
                    @empty
                    <td colspan="8">
                        <p class="text-center">No record found.</p>
                    </td>
                @endforelse
            </tbody>
        </table>
    </body>
</html>