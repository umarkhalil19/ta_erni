<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Form Tambah Data Master <small>Data Penyakit</small>
        </h1>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="card-title">
                            <div class="title">Form Tambah Data Penyakit</div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?= form_open(base_url('Users/user_update')) ?>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="sub-title">*Nama</div>
                                <div>
                                    <input type="hidden" name="id" value="<?= $user->user_id ?>">
                                    <input type="text" class="form-control" name="nama" placeholder="Nama" value="<?= $user->user_name ?>">
                                    <?php echo form_error('nama', '<small><span class="text-danger">', '</span></small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-title">*Email Aktif</div>
                                <div>
                                    <input type="text" class="form-control" name="email" placeholder="Email" value="<?= $user->user_email ?>">
                                    <?php echo form_error('email', '<small><span class="text-danger">', '</span></small>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="sub-title">*Username</div>
                                <div>
                                    <input type="text" class="form-control" name="username" placeholder="Username" value="<?= $user->user_login ?>">
                                </div>
                                <?php echo form_error('username', '<small><span class="text-danger">', '</span></small>'); ?>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-title">Password</div>
                                <div>
                                    <input type="text" class="form-control" name="password" value="Tidak Bisa Ubah Dari Menu ini!!!" readonly>
                                    <?php echo form_error('password', '<small><span class="text-danger">', '</span></small>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="sub-title">*Level Akses</div>
                                <div>
                                    <select name="level" id="level" class="form-control">
                                        <?php
                                        switch ($user->user_level) {
                                            case '99':
                                                $lvl = 'Admin';
                                                break;
                                            case '1':
                                                $lvl = 'User';
                                                break;

                                            default:
                                                $lvl = 'User';
                                                break;
                                        }
                                        ?>
                                        <option value="<?= $user->user_level ?>"><?= $lvl; ?></option>
                                        <option value="99">Admin</option>
                                        <option value="1">User</option>
                                    </select>
                                    <?php echo form_error('level', '<small><span class="text-danger">', '</span></small>'); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="sub-title">*Status</div>
                                <div>
                                    <select name="status" id="status" class="form-control">
                                        <option value="<?= $user->user_status ?>"><?= $user->user_status ?></option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                    <?php echo form_error('status', '<small><span class="text-danger">', '</span></small>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <small>* Tidak Boleh Kosong</small>
                            </div>
                            <div class="col-md-6">
                                <br>
                                <button class="btn btn-md btn-success pull-right" type="submit"><i class="fa fa-save"></i> Simpan Data</button>
                            </div>
                        </div>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>