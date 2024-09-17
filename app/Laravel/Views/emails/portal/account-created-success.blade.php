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
                            <p>Your account has been created successfully. Please use the following default password to log in:</p><br>
                            <table>
                                <tr>
                                    <td>
                                        <p><b>Default Password:</b></p>
                                    </td>
                                    <td>
                                        <p>{{$password}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p><b>Date time:</b></p>
                                    </td>
                                    <td>
                                        <p>{{$date_time}}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p>We recommend changing your password as soon as you log in for security reasons.</p>
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