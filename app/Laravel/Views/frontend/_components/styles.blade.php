<link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&amp;display=swap" rel="stylesheet">
<link href="{{asset('frontend/assets/css/app.css')}}" rel="stylesheet">

<link href="{{asset('frontend/assets/libs/sweetalert2/package/dist/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">

<style type="text/css">
    /* Chart.js */
    @keyframes chartjs-render-animation {
        from { opacity: 0.99; }
        to { opacity: 1; }
    }
    
    .chartjs-render-monitor {
        animation: chartjs-render-animation 0.001s;
    }
    
    .chartjs-size-monitor,
    .chartjs-size-monitor-expand,
    .chartjs-size-monitor-shrink {
        position: absolute;
        direction: ltr;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        overflow: hidden;
        pointer-events: none;
        visibility: hidden;
        z-index: -1;
    }
    
    .chartjs-size-monitor-expand > div {
        position: absolute;
        width: 1000000px;
        height: 1000000px;
        left: 0;
        top: 0;
    }
    
    .chartjs-size-monitor-shrink > div {
        position: absolute;
        width: 200%;
        height: 200%;
        left: 0;
        top: 0;
    }

    .sidebar, .sidebar-content {
        background: #7a6ad8 !important;
        color: whitesmoke !important; 
    }

    .sidebar-link{
        background: #7a6ad8 !important;
        color: whitesmoke !important; 
    }
</style>