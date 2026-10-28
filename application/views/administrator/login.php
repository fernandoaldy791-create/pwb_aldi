<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= html_escape($title); ?></title>
  <link rel="stylesheet" href="<?= base_url('assets/plugins/fontawesome-free/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('assets/dist/css/adminlte.min.css'); ?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo"><a href="<?= base_url('admin/login'); ?>"><b>Admin</b>LTE</a></div>
  <div class="card"><div class="card-body login-card-body">
    <p class="login-box-msg">Silakan login untuk memulai sesi</p>
    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><?= html_escape($this->session->flashdata('error')); ?></div>
    <?php endif; ?>
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <form action="<?= site_url('admin/auth'); ?>" method="post">
      <div class="input-group mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required autocomplete="username"><div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div></div>
      <div class="input-group mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password"><div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div></div>
      <button type="submit" class="btn btn-primary btn-block">Login</button>
    </form>
    <p class="mt-3 mb-0 text-muted text-center"><small>Pemrograman Web Bisnis</small></p>
  </div></div>
</div>
<script src="<?= base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?= base_url('assets/dist/js/adminlte.min.js'); ?>"></script>
</body></html>
