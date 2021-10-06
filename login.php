<?php include 'core/conex.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Promomedics</title>

    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo URL_ROOT ?>/css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">

    <style>
      .logo {
        /*margin-left: 44px;*/
        width: 100%;
      }
      .registration_form, .login_form {
        top: 60px;
      }
      .login{
        background-image: url(images/bg.jpg);
      }
    </style>
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <img src="images/logo.png" alt="Promomedics" class="logo">
        <div class="animate form login_form">
          <section class="login_content">
            <form id="form-login">
              <h1>Ingresar</h1>
              <div>
               
                <input id="username" type="text" class="form-control" placeholder="Username o Email" required="" />
              </div>
              <div>
                <input id="password" type="password" class="form-control" placeholder="Contraseña" required="" />
              </div>
              <div>
                <button id="btnLogin" type="button" class="btn btn-warning">Iniciar Sesión</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#signup" class="to_register"> ¿Olvidaste tu contraseña? </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>&nbsp;</h1>
                  <p><?php echo PAGE_TITLE; ?> © <?php echo date('Y'); ?> Todos los derechos reservados. </p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form id="form-forgot">
              <h1>Recuperar</h1>
              <p>Ingresa tu correo electrónico con el que estás registrado</p>
              <div>
                <input id="email" type="email" class="form-control" placeholder="Email" required="" />
              </div>
              <div>
                <button id="btnGenerate" type="button" class="btn btn-warning">Generar Contraseña</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">¿Ya tienes usuario y contraseña?
                  <a href="#signin" class="to_register"> Ingresa </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1>&nbsp;</h1>
                  <p><?php echo PAGE_TITLE; ?> © <?php echo date('Y'); ?> Todos los derechos reservados. </p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/jquery.json-2.4.min.js"></script>
    
    <script>
      $(document).ready(function() {
        $('#username').focus();

        $(document).keydown(function (key) {
            if (key.keyCode == '13') {
                if ($('#form-login').is(":visible")) {
                    $('#btnLogin').click();
                } else if ($('#form-forgot').is(":visible")) {
                    $('#btnGenerate').click();
                }
            } else if (key.keyCode == '27') {
                if ($('#form-forgot').is(":visible")) {
                    $('#btnForgotCancel').click();
                }
            }
        });

        $('#btnLogin').click(function(){
          $('.alert').alert('close');
          user = $.trim($('#username').val());
          pass = $.trim($('#password').val());
          err = $('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          if(user.length == 0){
            err.append('Debes ingresar tu email');
            $(this).before(err);
          }else if(pass.length == 0){
            err.append('Debes ingresar tu contraseña');
            $(this).before(err);
          }else{
            data = {
              user: user, 
              pass: pass
            };
            btn = $(this);
            btn.attr('disabled','');

            $.ajax({
                method:'POST',
                url: 'core/action.php',
                data: {
                    action:'login',
                    data: $.toJSON(data),
                }
            }).done(item => {
                if(item.error){
                    msg = 'No se encontro al usuario. Verifica tus datos.';
                    err.append(msg);
                    err.addClass('alert-danger');
                    btn.before(err);
                    btn.removeAttr('disabled');
                }else{
                    window.location = "<?php echo URL_ROOT; ?>";
                }
            }, 'json');

            /*
            $.post(
              'core/action.php',
              {action: 'login', data: $.toJSON(data)},
              function(data) {
                if(data.error){
                  msg = 'No se encontro al usuario. Verifica tus datos.';
                  err.append(msg);
                  err.addClass('alert-danger');
                  btn.before(err);
                  btn.removeAttr('disabled');
                }else{
                  window.location = "<?php echo URL_ROOT; ?>";
                }
              },'json')
              */
          }
        });

        $('#btnGenerate').click(function(e){
          e.preventDefault();
          $('.alert').alert('close');
          mail = $.trim($('#email').val());
          err = $('<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
          btn = $(this);
          if(mail.length == 0){
            err.append('Debes ingresar tu email');
            $(this).parent().before(err);
          }else{
            btn.addClass('disabled');
            $.post('core/action.php', 
              {action: 'recovery', mail: mail}, 
              function(resp) {
                if(resp.error){
                  err.addClass('alert-danger');
                }else{
                  err.addClass('alert-success');
                  $('#email').val('');
                  setTimeout(function() {
                    //$('#btnForgotCancel').trigger('click');
                    $('.alert').alert('close');
                  }, 5000);
                }
                err.append(resp.msg);
                btn.parent().before(err);
                btn.removeClass('disabled');
            },'json');
          }
        });
      });
    </script>

  </body>
</html>