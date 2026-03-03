  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="#">Office Stock Manager</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- Datatable JS -->
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- datepicker js  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<!-- select 2 js  -->
<script src="plugins/select2/js/select2.min.js"></script>

<!-- Custom Scripts -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/ajax_req.js"></script>
<!-- <script src="assets/js/buy_product.js"></script> -->

<script>
    function showAppToast(message, type) {
        var toast = document.createElement('div');
        toast.className = 'app-toast ' + (type || 'info');
        toast.textContent = message;
        document.body.appendChild(toast);

        requestAnimationFrame(function() {
            toast.classList.add('show');
        });

        setTimeout(function() {
            toast.classList.remove('show');
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 250);
        }, 2800);
    }

    // Replace blocking alerts with toasts for a smoother UX.
    window.alert = function(message) {
        showAppToast(String(message || 'Action completed'), 'info');
    };

    // Preloader
    function onReady(callback) {
        var intervalID = window.setInterval(checkReady, 1000);
        function checkReady() {
            if (document.getElementsByTagName('body')[0] !== undefined) {
                window.clearInterval(intervalID);
                callback.call(this);
            }
        }
    }

    function show(id, value) {
        var el = document.getElementById(id);
        if (el) el.style.display = value ? 'block' : 'none';
    }

    onReady(function () {
        show('page', true);
        show('loading', false);
    });

    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2();
        
        // Initialize Datepicker
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        // Dropdown submenu support
        $('.dropdown-submenu a.test').on("click", function(e){
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });
</script>

</body>
</html>
