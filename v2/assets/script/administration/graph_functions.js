

async function setup_graphs () {
    // PREPARE THE INPUTS
    
    [visitResponse, errorResponse, reportResponse, visitCleanResponse, newVisitorsResponse] = await Promise.all([
        axios.get("/forum/v2/assets/api/administration.php?epnt=visitGraph"),
        axios.get("/forum/v2/assets/api/administration.php?epnt=errorGraph"),
        axios.get("/forum/v2/assets/api/administration.php?epnt=reportGraph"),
        axios.get("/forum/v2/assets/api/administration.php?epnt=visitCleanGraph"),
        axios.get("/forum/v2/assets/api/administration.php?epnt=newVisitorsGraph")
    ]);

    let date_str = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Sep", "Oct", "Nov", "Dec"];
    let u_date = new Date(new Date().getTime() - 1000*60*60*24*graph_start_ago);
    let date_array = [];
    for (let i=0; i<graph_days_back; i++) { // Set i to days ago to start (150 = start 150 days ago)
        date_array.unshift(u_date.getDate() + ". " + date_str[u_date.getMonth()] + " " + u_date.getFullYear());

        u_date = new Date(u_date.getTime() - 1000*60*60*24) // Creation in miilliseconds, u_date.now() in seconds
    }

    chart_name_list = ["visitsClean", "visits", "error", "report"];
    chart_current = 0;

    let visitData = [];
    let errorData = [];
    let reportData = [];
    let visitCleanData = [];
    let newVisitorData = [];
    date_array.forEach((element, index) => {
        if (!(element in visitResponse.data)) {
            visitData.push(0);
        } else {
            visitData.push(visitResponse.data[element]);
        }

        if (!(element in errorResponse.data)) {
            errorData.push(0);
        } else {
            errorData.push(errorResponse.data[element]);
        }

        if (!(element in reportResponse.data)) {
            reportData.push(0);
        } else {
            reportData.push(reportResponse.data[element]);
        }

        if (!(element in visitCleanResponse.data)) {
            visitCleanData.push(0);
        } else {
            visitCleanData.push(visitCleanResponse.data[element]);
        }

        if (!(element in newVisitorsResponse.data)) {
            newVisitorData.push(0);
        } else {
            newVisitorData.push(newVisitorsResponse.data[element]);
        }
    })


    const def_options = {
        elements: {
            point: {
                radius: 0
            },
            line: {
                borderJoinStyle: 'round'
            }
        },
        responsive:true,
        maintainAspectRatio: false
    };


    visitChartSimple = new Chart(
        document.getElementById('visits-chart-simple-canvas'),
        {
            type: 'line',
            data: {
                labels: date_array,
                datasets: [{
                    label: 'Raw Visits',
                    backgroundColor: '#B7094C',
                    borderColor: '#B7094C',
                    data: visitData
                }]
            },
            options: def_options
        }
    );
    visitCleanChartSimple = new Chart(
        document.getElementById('visitsClean-chart-simple-canvas'),
        {
            type: 'line',
            data: {
                labels: date_array,
                datasets: [{
                    label: 'Clean Visits (Only one request per person and hour counted)',
                    backgroundColor: '#B7094C',
                    borderColor: '#B7094C',
                    data: visitCleanData
                },
                {
                    label: 'New visitors',
                    backgroundColor: 'blue',
                    borderColor: 'blue',
                    data: newVisitorData
                }]
            },
            options: def_options
        }
    );
    errorChartSimple = new Chart(
        document.getElementById('error-chart-simple-canvas'),
        {
            type: 'line',
            data: {
                labels: Object.keys(errorResponse.data),
                datasets: [{
                    label: 'Errors',
                    backgroundColor: '#B7094C',
                    borderColor: '#B7094C',
                    data: errorData
                }]
            },
            options: def_options
        }
    );
    reportChartSimple = new Chart(
        document.getElementById('report-chart-simple-canvas'),
        {
            type: 'line',
            data: {
                labels: Object.keys(reportResponse.data),
                datasets: [{
                    label: 'Reports',
                    backgroundColor: '#B7094C',
                    borderColor: '#B7094C',
                    data: reportData
                }]
            },
            options: def_options
        }
    );
}



function set_chart_in_gallery () {
    document.querySelectorAll(".chart-container").forEach((element, index) => {element.style.display = "none";})
    document.querySelector("." + chart_name_list[chart_current] + "-chart-simple-container").style.display = "";
}


function graph_settings_changed () {
    try {
        graph_days_back = parseInt(document.querySelector(".chart-gallery-stop").value);
    } catch (e) {
        console.debug(e);
    }
    try {
        graph_start_ago = parseInt(document.querySelector(".chart-gallery-start").value);
    } catch (e) {
        console.debug(e);
    }

    reload_graphs();
}


async function reload_graphs () {
    let date_str = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    let u_date = new Date(new Date().getTime() - 1000*60*60*24*graph_start_ago);
    let date_array = [];
    for (let i=0; i<graph_days_back; i++) { // Set i to days ago to start (150 = start 150 days ago)
        date_array.unshift(u_date.getDate() + ". " + date_str[u_date.getMonth()] + " " + u_date.getFullYear());
        u_date = new Date(u_date.getTime() - 1000*60*60*24) // Creation in miilliseconds, u_date.now() in seconds
    }

    chart_name_list = ["visitsClean", "visits", "error", "report"];
    chart_current = 0;

    let visitData = [];
    let errorData = [];
    let reportData = [];
    let visitCleanData = [];
    let newVisitorData = [];
    date_array.forEach((element, index) => {
        if (!(element in visitResponse.data)) {
            visitData.push(0);
        } else {
            visitData.push(visitResponse.data[element]);
        }

        if (!(element in errorResponse.data)) {
            errorData.push(0);
        } else {
            errorData.push(errorResponse.data[element]);
        }

        if (!(element in reportResponse.data)) {
            reportData.push(0);
        } else {
            reportData.push(reportResponse.data[element]);
        }

        if (!(element in visitCleanResponse.data)) {
            visitCleanData.push(0);
        } else {
            visitCleanData.push(visitCleanResponse.data[element]);
        }

        if (!(element in newVisitorsResponse.data)) {
            newVisitorData.push(0);
        } else {
            newVisitorData.push(newVisitorsResponse.data[element]);
        }
    })


    visitChartSimple.data.labels = date_array;
    errorChartSimple.data.labels = date_array;
    reportChartSimple.data.labels = date_array;
    visitCleanChartSimple.data.labels = date_array;
    visitChartSimple.data.datasets = [{
        label: 'Raw Visits',
        backgroundColor: '#B7094C',
        borderColor: '#B7094C',
        data: visitData
    }];
    visitChartSimple.update();
    errorChartSimple.data.datasets = [{
        label: 'Errors',
        backgroundColor: '#B7094C',
        borderColor: '#B7094C',
        data: errorData
    }];
    errorChartSimple.update();
    reportChartSimple.data.datasets = [{
        label: 'Reports',
        backgroundColor: '#B7094C',
        borderColor: '#B7094C',
        data: reportData
    }];
    reportChartSimple.update();
    visitCleanChartSimple.data.datasets = [{
        label: 'Clean Visits (Only one request per person and hour counted)',
        backgroundColor: '#B7094C',
        borderColor: '#B7094C',
        data: visitCleanData
    },
    {
        label: 'New visitors',
        backgroundColor: 'blue',
        borderColor: 'blue',
        data: newVisitorData
    }];
    visitCleanChartSimple.update();
}