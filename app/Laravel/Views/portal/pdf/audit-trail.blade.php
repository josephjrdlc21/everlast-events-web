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
                        <p class="lh1 fs14 text-center"><b>Audit Trail</b></p>
                        <p class="lh1 fs14 text-center"><b>{{Carbon::now()->format('F d, Y g:i A')}}</b></p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%" cellpadding="1" cellspacing="0">
            <thead>
                <tr>
                    <th class="text-center text-uppercase fs14">Name</th>
                    <th class="text-center text-uppercase fs14">IP Address</th>
                    <th class="text-center text-uppercase fs14">Remarks</th>
                    <th class="text-center text-uppercase fs14">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($record as $index => $audit_trail)
                    <tr>
                        <td>{{$audit_trail->user->name ?? ''}}</td>
                        <td>{{$audit_trail->ip ?? ''}}</td>
                        <td>{{$audit_trail->remarks ?? ''}}</td>
                        <td>{{Carbon::parse($audit_trail->created_at)->format('m/d/Y h:i A') ?? ''}}</td>
                    </tr>
                    @empty
                    <td colspan="4">
                        <p class="text-center">No record found.</p>
                    </td>
                @endforelse
            </tbody>
        </table>
    </body>
</html>