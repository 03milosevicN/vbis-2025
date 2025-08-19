<div class="card">
    <div class="card-body">
        <div class="row">

            <div class="col-md-6">
                <div class="chart">
                    <div id="get-users-per-course-canvas">
                        
                        <canvas id="users-per-course" width="400" height="200">

                        </canvas>

                    </div>
                </div>
                <button id="download-users" class="btn btn-primary">Export</button>
            </div>


            <div class="col-md-6">
                <div class="chart">
                    <div id="get-average-progress-per-course-canvas" >
                        
                        <canvas id="average-progress-per-course" width="400" height="200">
                            
                        </canvas>

                    </div>
                </div>
                <button id="download-progress" class="btn btn-primary">Export</button>
            </div>

        </div>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
$(document).ready(function() {
    getUsersPerCourse();
    getAverageProgressPerCourse();
});

$("#download-users").click(function() {
    downloadJSON(usersPerCourseData, "users_per_course.json");
});

$("#download-progress").click(function() {
    downloadJSON(averageProgressData, "average_progress.json");
});

let usersPerCourseData = [];
let averageProgressData = [];

function getUsersPerCourse() {

    let URL = '/adminPanel/getUsersPerCourse';

    $.getJSON(URL, function(result) {

        usersPerCourseData = result;

        let labels = result.map(function(e) {
            return e.title; 
        });

        let values = result.map(function(e) {
            return parseInt(e.number_of_users); 
        });

        let setData = {
            labels: labels,
            datasets: [{
                label: "Number of Users per Course",
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        };

        let options = {
            scales: {
                y: { beginAtZero: true }
            }
        };

        let graph = $("#users-per-course").get(0).getContext('2d');
        createGraph(setData, graph, 'bar', options);
    });
}

function getAverageProgressPerCourse() {

    let URL = '/adminPanel/getAverageProgressPerCourse';

    $.getJSON(URL, function(result) {

        averageProgressData = result;

        let labels = result.map(function(e) {
            return e.title; 
        });

        let values = result.map(function(e) {
            return e.average_progress ? parseFloat(e.average_progress) : 0; 
        });

        let setData = {
            labels: labels,
            datasets: [{
                label: "Average Progress per Course (%)",
                data: values,
                borderColor: 'rgba(255, 99, 132, 0.8)',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true
            }]
        };

        let options = {
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        };

        let graph = $("#average-progress-per-course").get(0).getContext('2d');
        createGraph(setData, graph, 'line', options);
    });
}

function createGraph(setData, graph, chartType, options) {
    new Chart(graph, {
        type: chartType,
        data: setData,
        options: options
    });
}

function downloadJSON(data, filename) {
    const jsonStr = JSON.stringify(data, null, 2);
    const blob = new Blob([jsonStr], { type: "application/json" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    a.click();

    URL.revokeObjectURL(url);
}
</script>


