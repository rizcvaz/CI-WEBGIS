<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SIGABAR | <?= $judul ?></title>

  <link rel="icon" type="image/png" href="<?= base_url('logo/logo.png') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('AdminLTE/dist/css/adminlte.min.css') ?>">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?= base_url('/') ?>" class="h1"><b>SIG</b>ABAR</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

      <?php $errors = session()->getFlashdata('errors'); ?>

      <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= session()->getFlashdata('success') ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if (!empty($errors)): ?>
        <?php foreach ((array)$errors as $error): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $error ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <form action="<?= base_url('Auth/CekLogin') ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control <?= !empty($errors['email']) ? 'is-invalid' : '' ?>" placeholder="Email" value="<?= old('email') ?>" autofocus>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <?php if (!empty($errors['email'])): ?>
          <div class="text-danger small mb-2"><?= $errors['email'] ?></div>
        <?php endif; ?>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control <?= !empty($errors['password']) ? 'is-invalid' : '' ?>" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <?php if (!empty($errors['password'])): ?>
          <div class="text-danger small mb-2"><?= $errors['password'] ?></div>
        <?php endif; ?>

        <div class="row">
          <div class="col-8">
            <a href="<?= base_url('Auth/Register') ?>">Belum punya akun? Daftar di sini</a>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>

<script src="<?= base_url('AdminLTE/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('AdminLTE/dist/js/adminlte.min.js') ?>"></script>
<script>
  $(document).ready(function () {
    setTimeout(() => {
      $(".alert").fadeOut(500, function () {
        $(this).remove();
      });
    }, 3000);
  });
</script>

</body>
</html>
