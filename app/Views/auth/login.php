
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-5">

        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">User Login</h4>
            </div>

            <div class="card-body">

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('login') ?>" method="post">

                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Login
                    </button>

                </form>

            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
