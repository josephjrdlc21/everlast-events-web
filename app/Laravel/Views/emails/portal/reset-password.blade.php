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
                            <h4 class="mb-3">Reset Password</h4>
                            <table>
                                <tr>
                                    <td>
                                        <a href="{{route('portal.auth.reset_password', [$token])}}" class="btn-primary mb-3">Click to Reset Password</a>
                                    </td>
                                </tr>
                            </table>
                            <p>Regards,<br> Support Team</p>
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