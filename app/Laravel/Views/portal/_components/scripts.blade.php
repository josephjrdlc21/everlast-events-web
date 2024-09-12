<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery-easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
<script src="{{asset('assets/libs/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('assets/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('assets/js/demo/chart-pie-demo.js')}}"></script>
<script src="{{asset('assets/js/demo/chart-bar-demo.js')}}"></script>

<script src="{{asset('assets/libs/sweetalert2/package/dist/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/libs/sweetalert2/package/dist/sweetalert2.all.min.js')}}"></script>

<script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
<script src="{{asset('assets/libs/daterangepicker/daterangepicker.js')}}"></script>

{{-- CK Editor --}}
<script src="{{ asset('assets/libs/ckeditor5/build/ckeditor.js') }}"></script>

<script>
    ClassicEditor.create(document.querySelector('#editor'), {
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
            ]
        },
        link: {
            decorators: {
                openInNewTab: {
                    mode: 'manual',
                    label: 'Open in a new tab',
                    attributes: {
                        target: '_blank',
                        rel: 'noopener noreferrer'
                    }
                }
            }
        }
    })
    .catch(error => {
        //console.error(error);
    });
</script>
{{-- End CK Editor --}}