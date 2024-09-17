@extends('emails._layouts.main')

@section('content')
<table class="body-wrap">
	<tr>
		<td class="container" style="background-color: #FFFFFF">
			<div class="content">
                <table>
                    <tr>
                        <td>
                            <h2>{{$setting ?? 'Event System'}}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <h4>Hello! {{$email}}</h4><br>
                            @if($status == "approved")
                            <p>Congratulations! Your account has been approved. You can now log in!</p><br>
                            @else
                            <p>We regret to inform you that your account application has been cancelled or not been processed. If you believe this is a mistake or would like more information, please contact our support team.</p><br>
                            @endif
                            <table>
                                <tr>
                                    <td>
                                        <p><b>Date time:</b></p>
                                    </td>
                                    <td>
                                        <p>{{$date_time}}</p>
                                    </td>
                                </tr>
                            </table>
                            <br><p>Regards,<br> Support Team</p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="footnote">If you have any inquiries, please feel free to contact us through (+63) 47 361 2178 / (+63) 900 666
                            4456 or support@eventmanager.com</p>
                        </td>
                    </tr>
                </table>
			</div>				
		</td>
	</tr>
</table>
@stop