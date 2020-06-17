<div class="row">
    <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Data Pengguna</h5>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table
                        class="table
                            table-striped
                            table-bordered
                            table-hover
                            xtable">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Username</th>
                                <th>Level</th>
                                <th>Nama Lengkap</th>
                                <th>No. Telepon</th>
                                <th>Email</th>
                                <th class="text-center">
                                    <i class="fa fa-sliders"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pengguna as $num => $list): ?>
                                <tr>
                                    <td class="text-center"><?= $num+1 ?></td>
                                    <td><?= $list['username'] ?></td>
                                    <td>
                                        <?php if(isset($level[$list['level']])): ?>
                                            <?= ucwords($level[$list['level']]) ?>        
                                        <?php else: ?>
                                            Belum ditentukan
                                        <?php endif ?>
                                    </td>
                                    <td><?= $list['nama'] ?></td>
                                    <td><?= $list['notelepon'] ?></td>
                                    <td><?= $list['email'] ?></td>
                                    <td class="text-center">
                                        <a
                                            href="<?= url('app/admin/pengguna/edit?id='.$list['id']) ?>"
                                            class="btn
                                                btn-xs
                                                btn-warning">
                                            <i class="fa fa-edit"></i>
                                            Ubah
                                        </a>
                                        <a
                                            href="<?= url('app/admin/pengguna/destroy?id='.$list['id']) ?>"
                                            class="btn btn-xs btn-danger xlink">
                                            <i class="fa fa-trash-o"></i>
                                            Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <a
                            href="<?= url('app/admin/pengguna/create') ?>"
                            class="btn btn-primary pull-right">
                            <i class="fa fa-plus"></i> Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>