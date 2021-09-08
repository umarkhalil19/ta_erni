<div id="page-wrapper">
    <div class="header">
        <h1 class="page-header">
            Data Tabel <small>Tabel Users</small>
        </h1>
        <?php if (isset($_GET['notif'])) : _notif($this->session->flashdata($_GET['notif']));
        endif; ?>
    </div>
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabel Data Users
                        <a href="<?= base_url('Users/user_add') ?>" class="btn btn-md btn-success pull-right"><i class="fa fa-plus"> Tambah Data</i></a>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Username</th>
                                        <th>Level</th>
                                        <th>Status & Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($user->result() as $u) :
                                        switch ($u->user_level) {
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
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $u->user_name ?></td>
                                            <td><?= $u->user_email ?></td>
                                            <td><?= $u->user_login ?></td>
                                            <td><?= $lvl ?></td>
                                            <td>
                                                <label class="badge badge-dark"><?= $u->user_status ?></label><br>
                                                <a href="<?= base_url('Users/user_edit/' . $u->user_id) ?>" class="btn btn-sm btn-primary"><small class="fa fa-wrench"></small></a>
                                                <a href="<?= base_url('Users/user_delete/' . $u->user_id) ?>" class="btn btn-sm btn-danger"><small class="fa fa-trash-o"></small></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
    <footer></footer>