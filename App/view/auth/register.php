<img width="250px" src="<?= url('assets/img/logo/' . config('logo')) ?>">

<h4 class="m-t">
    <?= config('app.appname') ?>
</h4>
<p><?= config('app.appfullname') ?></p>


<form
    action="<?= url('app/auth/register') ?>"
    method="post"
    class="m-t xform">
    <div class="form-group">
        <input
            type="text"
            class="form-control"
            name="username"
            placeholder="Username">
    </div>
    <div class="form-group">
        <input
            type="text"
            class="form-control"
            name="nama"
            placeholder="Nama Lengkap">
    </div>
    <div class="form-group">
        <input
            type="text"
            class="form-control"
            name="email"
            placeholder="Email">
    </div>
    <div class="form-group">
        <input
            type="text"
            class="form-control"
            name="notelepon"
            placeholder="No. Telepon">
    </div>
    <div class="form-group">
        <input
            type="password"
            class="form-control"
            name="password"
            placeholder="Kata Sandi">
    </div>
    <div class="form-group">
        <input
            type="password"
            class="form-control"
            name="re_password"
            placeholder="Konfirmasi Kata Sandi">
    </div>
    <button type="submit" class="btn btn-primary block full-width m-b">
        Daftar
    </button>

    <p class="text-muted text-center">
        <small>Sudah mempunyai akun?</small>
    </p>
    <a
        href="<?= url('app/auth/login') ?>"
        class="btn btn-sm btn-white btn-block">
        Masuk
    </a>
</form>

<p class="m-t">
    <small><?= config('app.developer') ?></small>
</p>