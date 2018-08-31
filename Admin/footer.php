  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#">GhurteJai</a>.</strong> All rights reserved.
  </footer>

  <!-- Add the sidebar's background. This div must be placed
  immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. -->

<!--Enabling Froala Editor -->
    <!-- Include external JS libs. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/mode/xml/xml.min.js"></script>

<!-- Include Editor JS files. -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.4/js/froala_editor.pkgd.min.js"></script>

<!-- <script> $(function() { $('#packageDesc').froalaEditor() }); </script> -->
<script type="text/javascript">
  $(".username-unavailable").css("display", "none");
  $(document).ready(function() {
  $('#username').keyup(function() {
    var value = $(this).val();
    
    $.ajax({
      type: 'post',
      url: 'user_available_check.php',
      data: {'username' : value},
      success: function(r) {
        $('.username-unavailable').html(r);
        $(".username-unavailable").css("display", "");
      }
    });
  });
});
</script>
    <script type="text/javascript">
    $(".email-unavailable").css("display", "none");
    $(document).ready(function() {
    $('#email').keyup(function() {
    var value = $(this).val();
    
    $.ajax({
      type: 'post',
      url: 'email_available_check.php',
      data: {'email' : value},
      success: function(r) {
        $('.email-unavailable').html(r);
        $(".email-unavailable").css("display", "");
       }
      });
      });
      });
    </script>
</body>
</html>