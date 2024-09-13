<link href="{{asset('assets/libs/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

<link href="{{asset('assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/libs/sweetalert2/package/dist/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/libs/daterangepicker/daterangepicker.css')}}" rel="stylesheet">

<style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}
    .chartjs-render-monitor{animation:chartjs-render-animation 1ms}
    .chartjs-size-monitor,.chartjs-size-monitor-expand,
    .chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}
    .chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}
    .chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}

    a:hover {
        text-decoration: none;
    }

    .ck-editor__editable[role="textbox"]{
        min-height: 250px;
    }

    .img-wrapper {
        overflow: hidden;
        position: relative;
    }

    .img-wrapper img {
        width: 100%;
        height: auto;
        display: block;
    }

    ::-webkit-scrollbar {
        width: 12px;
        height: 12px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #888;
        border-radius: 10px;
        border: 2px solid #f1f1f1;
    }

    ::-webkit-scrollbar-thumb:hover {
        background-color: #555;
    }

    input::-webkit-outer-spin-button,
	input::-webkit-inner-spin-button {
		-webkit-appearance: none;
		margin: 0;
	}
    
	input[type=number] {
		-moz-appearance: textfield;
	}

    .date-picker {
        cursor: pointer;
    }

    .date-picker-time {
        cursor: pointer;
    }

    .auth-background {
        position: relative;
    }

    .auth-svg {
        position: absolute;
        bottom: 0;
        top: 0;
    }

    .auth-border{
        border-radius: 10rem !important;
    }
</style>