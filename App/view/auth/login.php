<img width="250px" src="<?= url('assets/img/logo/' . config('logo')) ?>">

<h4 class="m-t">
    <?= config('app.appname') ?>
</h4>

<p><?= config('app.appfullname') ?></p>

<form
    action="<?= url('app/auth/login') ?>"
    method="post"
    class="m-t xform">
    <div class="form-group">
        <input
            type="text"
            class="form-control"
            name="username"
            placeholder="Username"
            autofocus>
    </div>
    <div class="form-group">
        <input
            type="password"
            class="form-control"
            name="password"
            placeholder="Kata Sandi">
    </div>

    <button type="submit" class="btn btn-primary block full-width m-b">
        Masuk
    </button>

    <!-- <a href="#"><small>Forgot password?</small></a> -->
    <p class="text-muted text-center"><small>Belum mempunyai akun?</small>
    </p>
    <a
        href="<?= url('app/auth/register') ?>"
        class="btn btn-sm btn-white btn-block">
        Daftar
    </a>

</form>

<p class="m-t">
    <small><?= config('app.developer') ?></small>
</p>