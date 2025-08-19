<?php use app\models\CoursesModel; ?>


<?php foreach ($params as $course): ?>
    <div class="course-card"> <img src="/assets/img/bg/<?= $course->courses_id ?>.png" alt="course">
        <h3><?= htmlspecialchars($course->title) ?></h3>
        <p><?= htmlspecialchars($course->description) ?></p> <button class="btn-enroll"
            data-course-id="<?= $course->courses_id ?>"> Enroll Now </button>
        <div class="enroll-notification" style="display:none; margin-top:5px;"></div>
    </div> 
<?php endforeach; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.btn-enroll');

    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            const courseId = this.getAttribute('data-course-id');
            const notification = this.nextElementSibling;

            fetch('/courses/enroll', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `course_id=${courseId}`
            })
            .then(response => response.json())
            .then(data => {
                notification.style.display = 'block';
                notification.style.color = data.status === 'success' ? 'green' : 'red';
                notification.textContent = data.message;

                if (data.status === 'success') {
                    this.innerText = "Enrolled";
                    this.disabled = true;
                }
            })
            .catch(error => {
                notification.style.display = 'block';
                notification.style.color = 'red';
                notification.textContent = 'An error occurred. Try again.';
                console.error(error);
            });
        });
    });
});
</script>

<style>
.card-img-top {
    max-height: 300px;
    object-fit: cover;
}
.enroll-notification {
    font-weight: bold;
}
</style>