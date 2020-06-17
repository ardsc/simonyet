<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Form Ubah Pengguna</h5>
            </div>
            <div class="ibox-content">
                <form
                    action="<?= url('app/admin/pengguna/update') ?>"
                    method="post"
                    class="m-t xform">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $pengguna['id'] ?>">
                    
                    <div class="form-group">
                        <label class="control-label">
                            Username
                        </label>
                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            value="<?= $pengguna['username'] ?>"
                            disabled>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Level</label>
                        <select
                            class="form-control"
                            name="level">
                            <?php foreach ($level as $value => $name): ?>
                                <?php if ($value == $pengguna['level']): ?>
                                    <option value="<?= $value ?>" selected>
                                        <?= ucwords($name) ?>
                                    </option>
                                <?php else: ?>
                                    <option value="<?= $value ?>">
                                        <?= ucwords($name) ?>
                                    </option>
                                <?php endif ?>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nama Lengkap</label>
                        <input
                            type="text"
                            class="form-control"
                            name="nama"
                            value="<?= $pengguna['nama'] ?>"
                            placeholder="Nama Lengkap">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Email</label>
                        <input
                            type="text"
                            class="form-control"
                            name="email"
                            value="<?= $pengguna['email'] ?>"
                            placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label class="control-label">No. Telepon</label>
                        <input
                            type="text"
                            class="form-control"
                            name="notelepon"
                            value="<?= $pengguna['notelepon'] ?>"
                            placeholder="No. Telepon">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Kata Sandi</label>
                        <div class="alert alert-info">
                            Kosongkan bila tidak merubah Kata Sandi
                        </div>
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