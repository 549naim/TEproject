<div class="modal fade" id="show_course" tabindex="-1" aria-labelledby="create_courseLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_courseLabel">Student List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="student_list_data" style="max-height: 700px; overflow-y: auto;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="student_list_print">Print</button>

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '#student_list_print', function() {
            var printContents = document.getElementById('student_list_data').innerHTML;
            var printWindow = window.open('', '', 'height=800,width=1000');
            printWindow.document.write('<html><head><title>Student Data</title>');
            // Inline Bootstrap and custom styles for modal body look
            printWindow.document.write(
                `<link rel="stylesheet" href="{{ asset('css/app.css') }}">
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            background: #f8fafc;
                            margin: 0;
                            padding: 0;
                        }
                        .modal-content {
                            border-radius: 0.5rem;
                            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.05);
                            background: #fff;
                            margin: 40px auto;
                            max-width: 900px;
                            padding: 0;
                        }
                        .modal-header, .modal-footer {
                            display: none;
                        }
                        .modal-body {
                            border-radius: 0.5rem;
                            background: #fff;
                            padding: 1.5rem !important;
                        }
                        .p-4 { padding: 1.5rem !important; }
                        .table { width: 100%; border-collapse: collapse; }
                        .table-bordered th, .table-bordered td { border: 1px solid #dee2e6 !important; }
                        .table thead th { background: #f1f1f1; }
                        .fw-semibold, .font-semibold { font-weight: 600; }
                        h6.fw-bold { margin-top: 1rem; }
                        ul.ms-3 { margin-left: 1rem; }
                        .row { display: flex; flex-wrap: wrap; margin-right: -12px; margin-left: -12px; }
                        .col-md-6 { flex: 0 0 auto; width: 50%; padding-right: 12px; padding-left: 12px; }
                        .mb-3 { margin-bottom: 1rem !important; }
                        .mt-4 { margin-top: 1.5rem !important; }
                        .text-right { text-align: right !important; }
                    </style>`
            );
            printWindow.document.write('</head><body>');
            printWindow.document.write(
                '<div class="modal-content"><div class="modal-body overflow-auto" style="max-height: 90vh;">'
            );
            printWindow.document.write(printContents);
            printWindow.document.write('</div></div>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        });
    });
</script>
