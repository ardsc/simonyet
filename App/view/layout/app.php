<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= config('app.appname') ?></title>

    <?php self::css() ?>
    <?php self::js() ?>


    <script type="text/javascript">
        const baseurl = '<?= url() ?>'
    </script>

</head>

<body>

    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span class="block m-t-xs font-bold">
                                <?= session('pengguna.nama') ?>
                            </span>
                            <span class="text-muted text-xs block">
                                <?= session('pengguna.username') ?>
                            </span>
                        </div>
                        <div class="logo-element">
                            <?= config('app.appname') ?>
                        </div>
                    </li>
                    <li class="<?= (isset($page) and $page == 'home') ? 'active' : null ?>">
                        <a href="<?= url() ?>">
                            <i class="fa fa-home"></i>
                            <span class="nav-label">Halaman Awal</span>
                        </a>
                    </li>

                    <?php if ('admin' == session('pengguna.level')): ?>
                        <li class="<?= (isset($page) and $page == 'pengguna') ? 'active' : null ?>">
                            <a href="<?= url('app/admin/pengguna/index') ?>">
                                <i class="fa fa-users"></i>
                                <span class="nav-label">Pengguna</span>
                            </a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <?php if ('admin' == session('pengguna.level')): ?>
                            <li>
                                <a
                                    href="javascript:void(0)"
                                    class="dropdown-item pengaturan-aplikasi">
                                    <i class="fa fa-wrench"></i>
                                    Pengaturan
                                </a>
                            </li>
                        <?php endif ?>

                        <li>
                            <a
                                href="javascript:void(0)"
                                class="dropdown-item pengaturan-profil">
                                <i class="fa fa-user"></i>
                                Profil
                            </a>
                        </li>
                        <li>
                            <a
                                href="<?= url('app/auth/logout') ?>"
                                class="xlink">
                                <i class="fa fa-sign-out"></i>
                                Keluar
                            </a>

                        </li>
                    </ul>
                </nav>
            </div>

            <?php if (isset($breadcrumb)): ?>
                <div class="row wrapper border-bottom white-bg page-heading">
                    <div class="col-lg-12">
                        <h2><?= config('app.appname') ?></h2>
                        <ol class="breadcrumb">
                            <?php foreach ($breadcrumb as $url => $page): ?>
                                <?php if (end($breadcrumb) == $page): ?>
                                    <li class="breadcrumb-item active">
                                        <strong><?= $page ?></strong>
                                    </li>
                                <?php else: ?>
                                    <li class="breadcrumb-item">
                                        <a href="<?= url($url) ?>"><?= $page ?></a>
                                    </li>
                                <?php endif ?>
                            <?php endforeach ?>
                        </ol>
                    </div>
                </div>
            <?php endif ?>

            <div class="wrapper wrapper-content animated fadeInRight">
                <?php self::content() ?>
            </div>
            <div class="footer">
                <div class="pull-right">
                    <?= config('app.developer') ?>
                </div>
                <div>
                    <?= config('app.appfullname') ?>
                </div>
            </div>

        </div>
    </div>

    <?php if ('admin' == session('pengguna.level')): ?>
        <div class="modal inmodal fade" id="modal-pengaturan-aplikasi" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title nama-aplikasi"></h4>
                        <small class="font-bold nama-panjang-aplikasi"></small>
                    </div>
                    <div class="modal-body">
                        <div class="dropzone dropzone-logo"></div>
                    </div>
                    <form method="post" action="<?= url('app/base/update_aplikasi') ?>" class="xform">
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label class="control-label">Nama Singkat Aplikasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="appname"
                                    placeholder="Nama Singkat Aplikasi">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nama Panjang Aplikasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="appfullname"
                                    placeholder="Nama Panjang Aplikasi">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Info Aplikasi</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="appinfo"
                                    placeholder="Info Aplikasi">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Deskripsi Penjelasan Aplikasi</label>
                                <textarea
                                    name="appdesc"
                                    class="form-control"
                                    placeholder="Deskripsi Penjelasan Aplikasi"></textarea>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nama Pengembang</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="developer"
                                    placeholder="Nama Pengembang">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-dismiss="modal">
                                <i class="fa fa-times"></i>
                                Tutup
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif ?>
    
    <div class="modal inmodal fade" id="modal-pengaturan-profil" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title username-pengguna"></h4>
                    <small class="font-bold nama-pengguna"></small>
                </div>
                
                <form method="post" action="<?= url('app/base/update_profil') ?>" class="xform">
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="control-label">
                                Username
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                name="Username"
                                placeholder="Username" readonly>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label">Nama</label>
                            <input
                                type="text"
                                class="form-control"
                                name="nama"
                                placeholder="Nama">
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
                            <label class="control-label">Email</label>
                            <input
                                type="text"
                                class="form-control"
                                name="email"
                                placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Kata Sandi</label>
                            <div class="alert alert-info">
                                Kosongkan bila tidak merubah kata sandi
                            </div>
                            <input
                                type="password"
                                class="form-control"
                                name="password"
                                placeholder="Kata Sandi">
                        </div>
                        <div class="form-group">
                            <label class="control-label">Konfirmasi Kata Sandi</label>
                            <input
                                type="password"
                                class="form-control"
                                name="re_password"
                                placeholder="Konfirmasi Kata Sandi">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i>
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php if ('admin' == session('pengguna.level')): ?>
        <div class="modal inmodal fade" id="modal-download-logo" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title nama-logo"></h4>
                    </div>

                    <div class="modal-body text-center">
                        <img src="" alt="" class="img-fluid view-img-logo">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Tutup
                        </button>
                        <a href="" target="_blank" class="btn btn-primary link-download-logo">
                            <i class="fa fa-download"></i>
                            Unduh
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif ?>

    <script type="text/javascript">
        $(function(){
            $('a.pengaturan-profil').off('click').on('click', function(){


                $('h4.username-pengguna').text('<?= session('pengguna.username') ?>')
                $('small.nama-pengguna').text('<?= session('pengguna.nama') ?>')

                $('input[name=username]').val('<?= session('pengguna.username') ?>')
                $('input[name=nama]').val('<?= session('pengguna.nama') ?>')
                $('input[name=notelepon]').val('<?= session('pengguna.notelepon') ?>')
                $('input[name=email]').val('<?= session('pengguna.email') ?>')
                $('input[name=password]').val('')
                $('input[name=re_password]').val('')


                $('input[name=nama]').off('keyup').on('keyup', function(){
                    $('small.nama-pengguna').text($(this).val())
                })

                $('div#modal-pengaturan-profil').modal('show')
            })

            <?php if ('admin' == session('pengguna.level')): ?>
                $('a.pengaturan-aplikasi').off('click').on('click', function(){


                    $('h4.nama-aplikasi').text('<?= config('app.appname') ?>')
                    $('small.nama-panjang-aplikasi').text('<?= config('app.appfullname') ?>')


                    $('input[name=appname]').val('<?= config('app.appname') ?>')
                    $('input[name=appfullname]').val('<?= config('app.appfullname') ?>')
                    $('input[name=appinfo]').val('<?= config('app.appinfo') ?>')
                    $('input[name=appdesc]').val('<?= config('app.appdesc') ?>')
                    $('input[name=developer]').val('<?= config('app.developer') ?>')


                    $('input[name=appname]').off('keyup').on('keyup', function(){
                        $('h4.nama-aplikasi').text($(this).val())
                    })
                    $('input[name=appfullname]').off('keyup').on('keyup', function(){
                        $('small.nama-panjang-aplikasi').text($(this).val())
                    })

                    $('div#modal-pengaturan-aplikasi').modal('show')
                })

                $('div#modal-pengaturan-aplikasi').on('hidden.bs.modal', function(){
                    window.location.reload()
                })


                let upload_url = '<?= url("app/base/upload_logo") ?>'
                let read_url = '<?= url("app/base/read_logo") ?>'
                let delete_url = '<?= url("app/base/delete_logo") ?>'
                let download_url = '<?= url("app/base/download_logo") ?>'

                $('div.dropzone-logo').dropzone({
                    url: upload_url,
                    paramName : 'logo',
                    addRemoveLinks: true,
                    init : function(){


                        this.on('thumbnail', function(file) {
                            file.previewElement.addEventListener('click', function() {

                                $('img.view-img-logo').attr('alt', file.name)
                                $('img.view-img-logo').attr('src', download_url + '?file=' + file.name)

                                $('h4.nama-logo').text(file.name)
                                $('a.link-download-logo').attr('href', download_url + '?file=' + file.name)
                                $('div#modal-download-logo').modal('show')
                            })
                        })

                        let dropzone_logo = this

                        $.ajax({
                            url : read_url,
                            method : 'get',
                            success : function (res){

                                $.each(res, function(key, val) {
                                    
                                    let mockFile = {
                                        name: val.name,
                                        size: val.size
                                    }

                                    dropzone_logo.emit('addedfile', mockFile)
                                    dropzone_logo.emit('thumbnail', mockFile, val.url)
                                    dropzone_logo.emit('complete', mockFile)
                                })
                            }
                        })
                    },
                    accept: function(file, done){

                        if (file.type != 'image/jpeg' &&
                                file.type != 'image/jpg' &&
                                file.type != 'image/png') {

                            toastr.warning('File : ' + file.name, 'File harus berupa gambar')
                            file.previewElement.remove()
                        
                        } else {

                            done()
                        }
                    },
                    success : function(file, res){


                        if ('notfound' == res) {

                            toastr.error('File : ' + file.name, 'Gambar tidak ditemukan')
                            file.previewElement.remove()

                        } else if ('oversize' == res) {

                            toastr.error('File : ' + file.name, ' Ukuran file tidak boleh lebih dari 2mb')
                            file.previewElement.remove()

                        }else if('notallowed' == res) {

                            toastr.warning('File : ' + file.name, 'File harus berupa gambar')
                            file.previewElement.remove()

                        } else if('alreadyuploaded' == res){

                            toastr.info('File : ' + file.name, 'File telah diunggah sebelumnya')
                            file.previewElement.remove()

                        } else if ('uploaded' == res) {

                            toastr.success('File : ' + file.name, 'Proses unggah berhasil')
                        
                        } else {

                            toastr.error('File : ' + file.name, 'Proses unggah gagal')
                            file.previewElement.remove()
                        }
                    },
                    removedfile : function(file){
                        
                        $.ajax({
                            url : delete_url,
                            method : 'post',
                            data:{
                                name: file.name
                            },
                            success : function (res){
                                if ('deleted' == res) {
                                    toastr.info('File: ' + file.name, 'File telah dihapus')
                                }
                            }
                        })

                        let ref
                        return (ref = file.previewElement) != null ?
                            ref.parentNode.removeChild(file.previewElement) : void 0
                    }
                })
            <?php endif ?>
        })
    </script>
</body>

</html>
