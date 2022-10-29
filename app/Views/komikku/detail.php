<?= $this->extend('layout/template'); ?>

<?= $this->section('konten'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail Komikku</h2>
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $komikku['sampul']; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $komikku['judul']; ?></h5>
                            <p class="card-text"> <b> Penulis : </b> <?= $komikku['penulis']; ?> </p>
                            <p class="card-text"><small class="text-muted"><b> Penerbit : </b> <?= $komikku['penerbit']; ?></small></p>

                            <a href="/komikku/edit/<?= $komikku['slug']; ?>" class="btn btn-warning">Edit</a>

                            <form action="/komikku/<?= $komikku['id']; ?>" method="post" class="d-inline">
                                <?php csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yalin?')">Delete</button>
                            </form>

                            <br> <br>
                            <a href="/komikku/" class="btn btn-success">Kembali ke Daftar Komik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>