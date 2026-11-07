<?php

$employees = $employees ?? [];
$errors    = $errors ?? [];
$formMode  = $formMode ?? 'create';
$editId    = $editId ?? null;
$stats     = $stats ?? ['total' => 0, 'active' => 0, 'admins' => 0, 'managers' => 0];
$title     = $title ?? 'Employee Management Portal';

$hasErrors  = ! empty($errors);
$isEditForm = $hasErrors && $formMode === 'edit' && $editId;
$formAction = $isEditForm
    ? site_url('employees/update/' . (int) $editId)
    : site_url('employees/store');
$formTitle  = $isEditForm ? 'Edit Employee' : 'Add Employee';

$err = static fn (string $key) => $errors[$key] ?? null;

$statusValue = $hasErrors ? (old('status') ?: 'active') : 'active';

$badges = [
    'ADMIN'    => 'bg-danger',
    'MANAGER'  => 'bg-warning text-dark',
    'EMPLOYEE' => 'bg-info text-dark',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .card { border: 0; box-shadow: 0 2px 8px rgba(0, 0, 0, .06); }
        .stat-number { font-size: 1.8rem; font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="<?= site_url('employees') ?>"><?= esc($title) ?></a>
    </div>
</nav>

<div class="container pb-5">

    <!-- Flash messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('success')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= esc(session()->getFlashdata('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <?php
        $cards = [
            ['Total Employees', $stats['total'], 'text-dark'],
            ['Active',          $stats['active'], 'text-success'],
            ['Admins',          $stats['admins'], 'text-danger'],
            ['Managers',        $stats['managers'], 'text-warning'],
        ];
        foreach ($cards as [$label, $value, $cls]): ?>
            <div class="col-6 col-lg-3">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="text-muted small"><?= esc($label) ?></div>
                        <div class="stat-number <?= $cls ?>"><?= esc($value) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Header row -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h4 mb-0">Employees</h1>
        <button type="button" class="btn btn-primary" id="btnAdd">+ Add Employee</button>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body p-0">
            <?php if (empty($employees)): ?>
                <div class="text-center text-muted py-5">
                    <p class="fs-5 mb-1">No employees yet</p>
                    <p class="mb-0">Click "Add Employee" to create the first record.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th class="text-end">Salary (monthly)</th>
                                <th>Access</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($employees as $e):
                            $badge = $badges[$e['access_level']] ?? 'bg-secondary';
                        ?>
                            <tr>
                                <td><?= esc($e['id']) ?></td>
                                <td><?= esc($e['name']) ?></td>
                                <td><?= esc($e['email']) ?></td>
                                <td><?= esc($e['phone']) ?></td>
                                <td><?= esc($e['designation']) ?></td>
                                <td class="text-end"><?= esc(number_format((float) $e['salary'], 2)) ?></td>
                                <td><span class="badge <?= $badge ?>"><?= esc($e['access_level']) ?></span></td>
                                <td>
                                    <span class="badge <?= $e['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= esc(ucfirst((string) $e['status'])) ?>
                                    </span>
                                </td>
                                <td><?= esc($e['created_at']) ?></td>
                                <td class="text-end text-nowrap">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-edit"
                                            data-id="<?= (int) $e['id'] ?>"
                                            data-name="<?= esc($e['name'], 'attr') ?>"
                                            data-email="<?= esc($e['email'], 'attr') ?>"
                                            data-phone="<?= esc($e['phone'], 'attr') ?>"
                                            data-designation="<?= esc($e['designation'], 'attr') ?>"
                                            data-salary="<?= esc($e['salary'], 'attr') ?>"
                                            data-access="<?= esc($e['access_level'], 'attr') ?>"
                                            data-status="<?= esc($e['status'], 'attr') ?>">Edit</button>

                                    <form action="<?= site_url('employees/delete/' . (int) $e['id']) ?>"
                                          method="post" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ============ Add / Edit modal (one form for both) ============ -->
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form id="employeeForm" action="<?= esc($formAction, 'attr') ?>" method="post" novalidate>
                <?= csrf_field() ?>

                <div class="modal-header">
                    <h2 class="modal-title h5" id="modalTitle"><?= esc($formTitle) ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <?php if ($hasErrors): ?>
                        <div class="alert alert-danger">Please fix the errors below and try again.</div>
                    <?php endif; ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" maxlength="100"
                                   class="form-control <?= $err('name') ? 'is-invalid' : '' ?>"
                                   value="<?= old('name') ?>">
                            <div class="invalid-feedback"><?= esc($err('name')) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" maxlength="150"
                                   class="form-control <?= $err('email') ? 'is-invalid' : '' ?>"
                                   value="<?= old('email') ?>">
                            <div class="invalid-feedback"><?= esc($err('email')) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" maxlength="20"
                                   class="form-control <?= $err('phone') ? 'is-invalid' : '' ?>"
                                   value="<?= old('phone') ?>">
                            <div class="invalid-feedback"><?= esc($err('phone')) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" id="designation" name="designation" maxlength="100"
                                   class="form-control <?= $err('designation') ? 'is-invalid' : '' ?>"
                                   value="<?= old('designation') ?>">
                            <div class="invalid-feedback"><?= esc($err('designation')) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="salary" class="form-label">Salary (monthly)</label>
                            <input type="text" inputmode="decimal" id="salary" name="salary"
                                   class="form-control <?= $err('salary') ? 'is-invalid' : '' ?>"
                                   value="<?= old('salary') ?>">
                            <div class="invalid-feedback"><?= esc($err('salary')) ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="access_level" class="form-label">Access Level</label>
                            <select id="access_level" name="access_level"
                                    class="form-select <?= $err('access_level') ? 'is-invalid' : '' ?>">
                                <option value="">-- Select --</option>
                                <?php foreach (['ADMIN', 'MANAGER', 'EMPLOYEE'] as $lvl): ?>
                                    <option value="<?= $lvl ?>" <?= old('access_level') === $lvl ? 'selected' : '' ?>>
                                        <?= $lvl ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback"><?= esc($err('access_level')) ?></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-block">Status</label>
                            <?php foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $val => $label): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status"
                                           id="status_<?= $val ?>" value="<?= $val ?>"
                                           <?= $statusValue === $val ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_<?= $val ?>"><?= $label ?></label>
                                </div>
                            <?php endforeach; ?>
                            <?php if ($err('status')): ?>
                                <div class="text-danger small mt-1"><?= esc($err('status')) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    var modalEl   = document.getElementById('employeeModal');
    var modal     = new bootstrap.Modal(modalEl);
    var form      = document.getElementById('employeeForm');
    var titleEl   = document.getElementById('modalTitle');
    var storeUrl  = <?= json_encode(site_url('employees/store')) ?>;
    var updateUrl = <?= json_encode(site_url('employees/update')) ?>;

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(function (el) { el.classList.remove('is-invalid'); });
        var alertBox = form.querySelector('.alert-danger');
        if (alertBox) { alertBox.remove(); }
        form.querySelectorAll('.text-danger.small').forEach(function (el) { el.remove(); });
    }

    function fill(values) {
        ['name', 'email', 'phone', 'designation', 'salary'].forEach(function (f) {
            form.elements[f].value = values[f] || '';
        });
        form.elements['access_level'].value = values.access || '';
        var status = values.status || 'active';
        form.querySelector('input[name="status"][value="' + status + '"]').checked = true;
    }

    // Add
    document.getElementById('btnAdd').addEventListener('click', function () {
        clearErrors();
        fill({});
        form.action = storeUrl;
        titleEl.textContent = 'Add Employee';
        modal.show();
    });

    // Edit (pre-filled with saved values)
    document.querySelectorAll('.btn-edit').forEach(function (btn) {
        btn.addEventListener('click', function () {
            clearErrors();
            fill({
                name: btn.dataset.name,
                email: btn.dataset.email,
                phone: btn.dataset.phone,
                designation: btn.dataset.designation,
                salary: btn.dataset.salary,
                access: btn.dataset.access,
                status: btn.dataset.status
            });
            form.action = updateUrl + '/' + btn.dataset.id;
            titleEl.textContent = 'Edit Employee';
            modal.show();
        });
    });

    // Re-open the modal with errors + previous input after a failed validation
    <?php if ($hasErrors): ?>
    modal.show();
    <?php endif; ?>
})();
</script>
</body>
</html>