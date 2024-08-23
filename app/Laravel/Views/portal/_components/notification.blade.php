@if(session()->has('notification-status'))
<div class="alert alert-{{in_array(session()->get('notification-status'),['failed','error','danger']) ? 'danger' : session()->get('notification-status')}}" role="alert">
    <b>{{ucfirst(session()->get('notification-status'))}}!</b> {{session()->get('notification-msg')}}
</div>
@endif