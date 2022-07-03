<!-- jQuery 3 -->
<script src="{{ asset('template') }}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('template') }}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('template') }}/plugins/iCheck/icheck.min.js"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('template') }}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
</script>
<!-- DataTables -->
<script src="{{ asset('template') }}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('template') }}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{ asset('template') }}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ asset('template') }}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ asset('template') }}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('template') }}/dist/js/demo.js"></script>
<script>
    $(document).ready(function() {
        $('.sidebar-menu').tree()
    })
</script>

<script>
    $(document).ready(function() {
        $('#datatableid').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatablepertemuan').DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"]
            ],
            responsive: true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatableparticipant').DataTable({
            "lengthMenu": [
                [50, 75, 100, -1],
                [50, 75, 100, "All"]
            ],
            responsive: true,
        });
    });
</script>

<script>
    $('#datepicker').datepicker({
        autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
        checkboxClass: 'icheckbox_minimal-red',
        radioClass: 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass: 'iradio_flat-green'
    })
</script>
