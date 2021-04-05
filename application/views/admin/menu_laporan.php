<div class="container">
    <h1 class="mt-4">Laporan</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/Admin_Controller/index' ?>">Menu Utama</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan</li>
    </ol>
    <div class="row">
        <?php
        foreach ($countpeserta as $cunt) {    
        ?>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body"><?php echo $cunt->totalpeserta; ?> Peserta Terdaftar</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?php echo base_url().'admin/Admin_Controller/daftar_peserta' ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body"><?php echo $cunt->sedangmengerjakan; ?> Sedang Mengerjakan</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?php echo base_url().'admin/Admin_Controller/peserta_sedang_test' ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body"><?php echo $cunt->selesaimengerjakan; ?> Sudah Dinilai</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?php echo base_url().'admin/Admin_Controller/peserta_dinilai' ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body"><?php echo $cunt->belummengerjakan; ?> Belum Test</div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <a class="small text-white stretched-link" href="<?php echo base_url().'admin/Admin_Controller/peserta_belum_test' ?>">Lihat Detail</a>
                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-6">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    10 Nilai Terbaik
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID User</th>
                                    <th>Nama Lengkap</th>
                                    <th>No KTP</th>
                                    <th>Nilai Angka Hilang</th>
                                    <th>Nilai Huruf Hilang</th>
                                    <th>Nilai Simbol Hilang</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID User</th>
                                    <th>Nama Lengkap</th>
                                    <th>No KTP</th>
                                    <th>Nilai Angka Hilang</th>
                                    <th>Nilai Huruf Hilang</th>
                                    <th>Nilai Simbol Hilang</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php foreach ($top10 as $tp10) {
                                    
                                ?>
                                <tr>
                                    <td><?php echo $tp10->iduser ?></td>
                                    <td><a href="<?php echo base_url().'admin/Admin_Controller/detail_peserta/'.$tp10->iduser ?>"><?php echo $tp10->namleng ?></a></td>
                                    <td><?php echo $tp10->noktp ?></td>
                                    <td><?php echo $tp10->NilaiAngkaHilang ?></td>
                                    <td><?php echo $tp10->NilaiHurufHilang ?></td>
                                    <td><?php echo $tp10->NilaiSimbolHilang ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <div class="col-md-4">
            <div class="card mb-6">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Token Peserta
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                    <?php foreach ($pesertalisttoken as $tok) {
                        # code...
                    } ?>
                    <div id="tokenalertnganu">
                                    
                    </div>
                    <input type="text" class="form-control" id="tbtokenold" value="<?php echo $tok->token_access ?>" hidden>
                      <input type="text" class="form-control" id="tbtokenpeserta" placeholder="Masukan Token" aria-label="Masukan Token" aria-describedby="basic-addon2" value="<?php echo $tok->token_access ?>">
                      <div class="input-group-append">
                        <button class="btn btn-primary" id="btnupdatetoken" type="button">Update</button>
                      </div>
                    <?php ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>