<?php
use app\models\CoursesModel;

?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Courses</h1>
    </div>
  </div><!-- End Page Title -->

  <!-- Courses Section -->
<section id="courses-2" class="courses-2 py-5">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4" data-aos="fade-up" data-aos-delay="200">
            <?php foreach ($params as $course): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            <img src="/assets/img/bg/<?= htmlspecialchars($course['courses_id']) ?>.png" class="card-img-top" alt="<?= htmlspecialchars($course['title']) ?>">
                            <span class="badge bg-success position-absolute top-0 end-0 m-2">
                                $<?= htmlspecialchars($course['price']) ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($course['title']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($course['description']) ?></p>
                        </div>
                        <div class="card-footer text-center bg-white">
                            <a href="/courses/<?= $course['courses_id'] ?>" class="btn btn-primary w-100">Enroll Now</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</main>