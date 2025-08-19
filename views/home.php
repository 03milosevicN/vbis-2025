<?php
use app\models\CoursesModel;

/** @var $courses CoursesModel */
?>

<main class="main">

    <!-- Courses Hero Section -->
    <section id="courses-hero" class="courses-hero section light-background">

      <div class="hero-content">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
              <div class="hero-text">
                <h1>Transform Your Future with Expert-Led Online Courses</h1>
                <p>Discover thousands of high-quality courses designed by industry professionals. Learn at your own pace, gain in-demand skills, and advance your career from anywhere in the world.</p>

                <div class="hero-stats">
                  <div class="stat-item">
                    
                  </div>
                  <div class="stat-item">
                    
                  </div>
                  <div class="stat-item">
                    
                  </div>
                </div>

                <div class="hero-buttons">
                  <a href="courses" class="btn btn-primary">Browse Courses</a>
                </div>

                <div class="hero-features">
                  <div class="feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Certified Programs</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-clock"></i>
                    <span>Lifetime Access</span>
                  </div>
                  <div class="feature">
                    <i class="bi bi-people"></i>
                    <span>Expert Instructors</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
              <div class="hero-image">
                <div class="main-image">
                  <img src="assets/img/education/courses-13.webp" alt="Online Learning" class="img-fluid">
                </div>

                
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="hero-background">
        <div class="bg-shapes">
          <div class="shape shape-1"></div>
          <div class="shape shape-2"></div>
          <div class="shape shape-3"></div>
        </div>
      </div>

    </section><!-- /Courses Hero Section -->

    <!-- Featured Courses Section -->
    <section id="featured-courses" class="featured-courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Featured Courses</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="row gy-4">
    <?php foreach ($params as $course): ?>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
            <div class="course-card">
                <div class="course-image">
                    <img src="assets/img/bg/<?= htmlspecialchars($course['courses_id']) ?>.png" alt="course">
                    <div class="price-badge">$<?= htmlspecialchars($course['price']) ?></div>
                </div>
                <div class="course-content">
                    <h3><a href="#"><?= htmlspecialchars($course['title']) ?></a></h3>
                    <p><?= htmlspecialchars($course['description']) ?></p>
                    <a href="/courses/<?=$course['courses_id']?>" class="btn-course">Enroll Now</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

        </div>
    
      </div>

    </section><!-- /Featured Courses Section -->



    <!-- Cta Section -->
    <section id="cta" class="cta section light-background">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row align-items-center">

          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="200">
            <div class="cta-content">
              <h2>Transform Your Future with Expert-Led Online Courses</h2>
              <p>Join thousands of successful learners who have advanced their careers through our comprehensive online education platform.</p>

              <div class="features-list">
                <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
                  <i class="bi bi-check-circle-fill"></i>
                  <span>Expert instructors with industry experience</span>
                </div>
                <div class="feature-item" data-aos="fade-up" data-aos-delay="350">
                  <i class="bi bi-check-circle-fill"></i>
                  <span>Certificate of completion for every course</span>
                </div>
                <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                  <i class="bi bi-check-circle-fill"></i>
                  <span>24/7 access to course materials and resources</span>
                </div>
                <div class="feature-item" data-aos="fade-up" data-aos-delay="450">
                  <i class="bi bi-check-circle-fill"></i>
                  <span>Interactive assignments and real-world projects</span>
                </div>
              </div>

              <div class="cta-actions" data-aos="fade-up" data-aos-delay="500">
                <a href="courses" class="btn btn-primary">Browse Courses</a>
                <a href="#" class="btn btn-outline">Enroll Now</a>
              </div>

              <div class="stats-row" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-item">
                  
                </div>
                <div class="stat-item">
                  
                </div>
                <div class="stat-item">
                  
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
            <div class="cta-image">
              <img src="assets/img/education/courses-4.webp" alt="Online Learning Platform" class="img-fluid">
            </div>  
          </div>

        </div>

      </div>

    </section><!-- /Cta Section -->

  </main>