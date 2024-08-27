@if(session()->has('notification-status'))
<div class="p-3 mb-2 mt-2 rounded bg-{{in_array(session()->get('notification-status'),['failed','error','danger']) ? 'danger' : session()->get('notification-status')}}" disabled>
    <b class="text-white">{{ucfirst(session()->get('notification-status'))}}!</b> <span class="text-white">{{session()->get('notification-msg')}}</span>
</div>
@endif