
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= esc($title ?? 'Invoice App') ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
</head>

<body>

    <!-- Header -->
    <header class="bg-dark text-white p-3">
        <h3>Invoice Management System</h3>
    </header>

    <!-- Main content area -->
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <aside class="col-md-2 bg-light p-3">
                <h5>Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard') ?>">Dashboard</a>
                    </li>
                </ul>
            </aside>

            <!-- Page content -->
            <main class="col-md-10 p-4">

                <!-- Flash messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <?= esc(session()->getFlashdata('success')) ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session()->getFlashdata('error')) ?>
                    </div>
                <?php endif; ?>

                <!-- Individual page content appears here -->
                <?= $this->renderSection('content') ?>

            </main>

        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        <p class="mb-0">&copy; <?= date('Y') ?> Invoice App</p>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>
