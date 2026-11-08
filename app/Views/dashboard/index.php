
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <h2 class="mb-4">Dashboard</h2>

    <div class="alert alert-success">
        Welcome back, <?= esc(session()->get('user_name')) ?>!
        You are successfully logged in.
    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Customers</h5>
                    <p class="card-text">Manage your customers.</p>
                    <a href="#" class="btn btn-primary">View Customers</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text">Manage your products.</p>
                    <a href="#" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Invoices</h5>
                    <p class="card-text">Create and manage invoices.</p>
                    <a href="#" class="btn btn-primary">View Invoices</a>
                </div>
            </div>
        </div>

    </div>

    <form action="<?= site_url('logout') ?>" method="post">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn-danger mt-3">
            Logout
        </button>
    </form>

</div>

<?= $this->endSection() ?>
