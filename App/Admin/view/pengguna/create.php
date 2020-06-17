<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Form Tambah Pengguna</h5>
            </div>
            <div class="ibox-content">
                <form
                    action="<?= url('app/admin/pengguna/store') ?>"
                    method="post"
                    class="m-t xform">
                    <div class="form-group">
                        <label class="control-label">Username</label>
                        <input
                            type="text"
                            class="form-control"
                            name="username"
                            placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Level</label>
                        <select
                            class="form-control"
                            name="level">
                            <?php foreach ($level as $value => $name): ?>
                                <option value="<?= $value ?>">
                                    <?= ucwords($name) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama"
                            placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input
                            type="text"
                            class="form-control"
                            name="email"
                            placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="control-label">No. Telepon</label>
                        <input
                            type="text"
                            class="form-control"
                            name="notelepon"
                            placeholder="No. Telepon">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Kata Sandi</label>
                        <input
                            type="password"
                            class="form-control"
                            name="password"
                            placeholder="Kata Sandi">
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <button
                                type="submit"
                                class="btn btn-success pull-right">
                                <i class="fa fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>