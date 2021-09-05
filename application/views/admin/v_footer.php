</div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="<?= base_url() ?>assets/js/jquery-1.10.2.js"></script>
<!-- Chart Js -->
<script type="text/javascript" src="<?= base_url() ?>assets/js/Chart.min.js"></script>
<?php
$label_nb = $this->db->query("SELECT DISTINCT(penyakit_kode_nb) as label FROM tbl_pasien_uji ORDER BY penyakit_kode_nb ASC");
$label_ds = $this->db->query("SELECT DISTINCT(penyakit_kode_ds) as label FROM tbl_pasien_uji ORDER BY penyakit_kode_ds ASC");
?>
<script>
    $(function() {
        var ctx, data, myBarChart, option_bars;
        Chart.defaults.global.responsive = true;
        ctx = $('#bar-chart').get(0).getContext('2d');
        option_bars = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: false,
            barShowStroke: true,
            barStrokeWidth: 1,
            barValueSpacing: 5,
            barDatasetSpacing: 3,
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        };
        data = {
            labels: [
                <?php
                foreach ($label_nb->result() as $label) {
                    echo "'$label->label'" . ',';
                }
                ?>
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(26, 188, 156,0.6)",
                strokeColor: "#1ABC9C",
                pointColor: "#1ABC9C",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#1ABC9C",
                data: [
                    <?php
                    foreach ($label_nb->result() as $label) {
                        $nilai = $this->db->query("SELECT COUNT(pasien_uji_id) as nilai FROM tbl_pasien_uji WHERE penyakit_kode_nb='$label->label'")->row();
                        echo "$nilai->nilai" . ',';
                    }
                    ?>
                ]
            }]
        };
        myBarChart = new Chart(ctx).Bar(data, option_bars);
    });
</script>
<script>
    $(function() {
        var ctx, data, myBarChart, option_bars;
        Chart.defaults.global.responsive = true;
        ctx = $('#bar-chart-2').get(0).getContext('2d');
        option_bars = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: false,
            barShowStroke: true,
            barStrokeWidth: 1,
            barValueSpacing: 5,
            barDatasetSpacing: 3,
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
        };
        data = {
            labels: [
                <?php
                foreach ($label_ds->result() as $label) {
                    echo "'$label->label'" . ',';
                }
                ?>
            ],
            datasets: [{
                label: "My First dataset",
                fillColor: "rgba(26, 188, 156,0.6)",
                strokeColor: "#1ABC9C",
                pointColor: "#1ABC9C",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "#1ABC9C",
                data: [
                    <?php
                    foreach ($label_ds->result() as $label) {
                        $nilai = $this->db->query("SELECT COUNT(pasien_uji_id) as nilai FROM tbl_pasien_uji WHERE penyakit_kode_ds='$label->label'")->row();
                        echo "$nilai->nilai" . ',';
                    }
                    ?>
                ]
            }]
        };
        myBarChart = new Chart(ctx).Bar(data, option_bars);
    });
</script>

<!-- Bootstrap Js -->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

<!-- Metis Menu Js -->
<script src="<?= base_url() ?>assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<script src="<?= base_url() ?>assets/js/morris/raphael-2.1.0.min.js"></script>

<script src="<?= base_url() ?>assets/js/morris/morris.js"></script>

<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/dataTables.bootstrap.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
</script>

<!-- Custom Js -->
<script src="<?= base_url() ?>assets/js/custom-scripts.js"></script>




</body>

</html>