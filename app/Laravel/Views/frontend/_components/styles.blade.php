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

    a:hover {
        text-decoration: none;
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

    /* Custom Pagination Styles */
    #pagination {
        display: flex;
        margin: 20px 0;
        padding: 0;
    }

        /* Pagination List */
    .pagination {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
    }

    /* Pagination Item */
    .page-item {
        margin: 0 1px;
    }

    /* Pagination Link */
    .page-link {
        display: block;
        padding: 5px 10px; /* Smaller padding for small size */
        border: 1px solid #3b7ddd;
        border-radius: 4px;
        text-decoration: none;
        color: #3b7ddd;
        font-size: 14px; /* Smaller font size for small buttons */
        text-align: center;
        line-height: 1.2; /* Adjust line height for better alignment */
    }

    /* Active Pagination Link */
    .page-item.active .page-link {
        background-color: #3b7ddd;
        color: #fff;
        border-color: #3b7ddd;
    }

    /* Disabled Pagination Link */
    .page-item.disabled .page-link {
        background-color: #e9ecef;
        color: #6c757d;
        border-color: #e9ecef;
        pointer-events: none;
    }

    /* Hover State for Pagination Link */
    .page-link:hover {
        background-color: #2f64b1;
        color: white;
    }

    /* Add Custom Arrow Icons */
    .page-link.prev::before,
    .page-link.next::after {
        content: '';
        display: inline-block;
        width: 0;
        height: 0;
        border-style: solid;
    }

    .page-link.prev::before {
        border-width: 4px 8px 4px 0;
        border-color: transparent #3b7ddd transparent transparent;
        margin-right: 4px;
    }

    .page-link.next::after {
        border-width: 4px 0 4px 8px;
        border-color: transparent transparent transparent #3b7ddd;
        margin-left: 4px;
    }
</style>