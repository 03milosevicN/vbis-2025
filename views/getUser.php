<?php
use app\models\UserModel;
/** @var $user UserModel*/
/** @var $params CoursesModel */
?>

<div class="container my-5">

    <!-- User Info Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-1">User Information</h3>
        </div>
        <div class="card-body">
            <p><strong>First Name:</strong> <?= htmlspecialchars($params['user']['first_name'] ?? "NaN") ?></p>
            <p><strong>Last Name:</strong> <?= htmlspecialchars($params['user']['last_name'] ?? "NaN") ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($params['user']['email'] ?? "NaN") ?></p>
        </div>
    </div>

    <!-- Courses Section -->
    <h2 class="mb-3">My Courses</h2>

    <?php if (empty($params['courses'])): ?>
        <div class="alert alert-info">You haven't enrolled in any courses yet.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($params['courses'] as $course): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course->title) ?></h5>
                            <div class="mb-2">
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: <?= htmlspecialchars($course->progress) ?>%;" aria-valuenow="<?= htmlspecialchars($course->progress) ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= htmlspecialchars($course->progress) ?>%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                            <a href="/courses/<?= $course->courses_id ?>" class="btn btn-sm btn-primary">Go to Course</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Logout Button -->
    <div class="text-center mt-4">
        <a href="/processLogout" class="btn btn-outline-danger btn-lg">Logout</a>
    </div>

</div>
