<!doctype html>
<html lang="en">

<head>
    <title>Naive Bayes dan Dempster Shafer</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?= base_url() ?>assets/login/css/style.css">

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                            <div class="text w-100">
                                <h2>Selamat Datang</h2>
                                <p>Algoritma Naive Bayes & Dempster Shafer</p>
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5">
                            <?php if (isset($_GET['notif'])) : _notif($this->session->flashdata($_GET['notif']));
                            endif; ?>
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Login</h3>
                                </div>
                            </div>
                            <?= form_open('Login/cek') ?>
                            <div class="form-group mb-3">
                                <label class="label" for="name">Username</label>
                                <input type="text" class="form-control" placeholder="Username" name="username" required>
                            </div>
                            <div class="form-group mb-3">
                                <label class="label" for="password">Password</label>
                                <input type="password" class="form-control" placeholder="Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary submit px-3">Login</button>
                            </div>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?= base_url() ?>assets/login/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/login/js/popper.js"></script>
    <script src="<?= base_url() ?>assets/login/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/login/js/main.js"></script>

</body>

</html>