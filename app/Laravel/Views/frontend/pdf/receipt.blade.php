<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title></title>
    </head>
    <style>
        table, td, th {
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
        #header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 5cm;
            margin-left: 1cm;
            margin-right: 1cm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .border-none {
            border: none;
        }

        .mb-20 {
            margin-bottom: 20px;
        }

        body{
            font-size: 12px;
        }

        .border-white{
            border-color: white;
        }
    </style>
    <body>
        <table width="100%" cellpadding="0" cellspacing="0" class="border-none">
            <tbody>
                <tr class="border-none">
                    <td class="text-center border-none">
                        <p><b>Booking Receipt<br>{{Carbon::now()->format('F d, Y g:i A')}}</b></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0">
            <tbody>
                <tr>
                    <td>Name</td>
                    <td>{{$booking->user->name}}</td>
                </tr>
                <tr>
                    <td>Booking ID</td>
                    <td>{{$booking->code}}</td>
                </tr>
                <tr>
                    <td>Event Code</td>
                    <td>{{$booking->event->code}}</td>
                </tr>
                <tr>
                    <td>Event</td>
                    <td>{{$booking->event->name}}</td>
                </tr>
                <tr>
                    <td>Price</td>
                    <td>₱ {{$booking->event->price}}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{$booking->status}}</td>
                </tr>
                <tr>
                    <td>Payment</td>
                    <td>{{$booking->payment_status}}</td>
                </tr>
            </tbody>
        </table>
    </body>
</html>