<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">

            <li>
                <a href="<?= base_url('Admin') ?>"><i class="fa fa-dashboard"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-file"></i> Master Data<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('Gejala') ?>">Gejala</a>
                    </li>
                    <li>
                        <a href="<?= base_url('Data_latih') ?>">Data Latih</a>
                    </li>
                    <li>
                        <a href="<?= base_url('Data_uji') ?>">Data Uji</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"><i class="fa fa-file"></i> Algoritma<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="<?= base_url('Naive_bayes') ?>">Naive Bayes</a>
                    </li>
                    <li>
                        <a href="<?= base_url('Dempster_shafer') ?>">Dempster Shafer</a>
                    </li>
                </ul>
            </li>
        </ul>

    </div>

</nav>
<!-- /. NAV SIDE  -->