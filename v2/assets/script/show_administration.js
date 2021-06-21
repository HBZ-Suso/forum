var visitChartSimple;
var errorChartSimple;
var reportChartSimple;
var visitCleanChartSimple;
var chart_name_list;
var chart_current;
var graph_days_back = 60;
var graph_start_ago = 40;
var visitResponse;
var visitCleanResponse;
var errorResponse;
var reportResponse;
var newVisitorsResponse;

async function show_administration () {
    show_article(custom_html=true, heading="Administration", content_html=`
        <link rel="stylesheet" href="/forum/v2/assets/style/administration.css">
        <p>This is the official administration page of the HBZ-Forum. It can be used to do numerous things such as creating new account codes, managing, reading and deleting reports, looking at errors and visits and much more.</p>
        
        
        
        <h2>Charts</h2>
        <p>These charts can give you an overview of how the website has been doing over the last days, weeks, months or years and can help you to understand the traffic better.</p>
        <div class="chart-gallery">
            <div class="visitsClean-chart-simple-container chart-container" style="">
                <canvas id="visitsClean-chart-simple-canvas"></canvas>
            </div>
            <div class="visits-chart-simple-container chart-container" style="display: none;">
                <canvas id="visits-chart-simple-canvas"></canvas>
            </div>
            <div class="error-chart-simple-container chart-container" style="display: none;">
                <canvas id="error-chart-simple-canvas"></canvas>
            </div>
            <div class="errorType-chart-simple-container chart-container" style="display: none;">
                <canvas id="errorType-chart-simple-canvas"></canvas>
            </div>
            <div class="report-chart-simple-container chart-container" style="display: none;">
                <canvas id="report-chart-simple-canvas"></canvas>
            </div>
        </div>
        <div class="chart-control-container">
            <button class="chart-gallery-left chart-gallery-control">Left</button>
            <button class="chart-gallery-control chart-gallery-number-control" onclick="document.querySelector('.chart-gallery-start').value = parseInt(document.querySelector('.chart-gallery-start').value) - 10;graph_settings_changed();"><</button>
            <input class="chart-gallery-control chart-gallery-number  chart-gallery-start" placeholder="Start X days ago" value="0">
            <button class="chart-gallery-control chart-gallery-number-control" onclick="document.querySelector('.chart-gallery-start').value = parseInt(document.querySelector('.chart-gallery-start').value) + 10;graph_settings_changed();">></button>
            <button class="chart-gallery-control chart-gallery-number-control" onclick="document.querySelector('.chart-gallery-stop').value = parseInt(document.querySelector('.chart-gallery-stop').value) - 10;graph_settings_changed();"><</button>
            <input class="chart-gallery-control chart-gallery-number  chart-gallery-stop" placeholder="Show a timespan of X days" value="30">
            <button class="chart-gallery-control chart-gallery-number-control" onclick="document.querySelector('.chart-gallery-stop').value = parseInt(document.querySelector('.chart-gallery-stop').value) + 10;graph_settings_changed();">></button>
            <button class="chart-gallery-right chart-gallery-control">Right</button>
        </div>



        <h2>Code Creation<img class="danger-warning" src="/forum/assets/img/icon/warning_black_24dp.svg"></h2>
        <p>Use this tool to create and manage account creation codes. Please be careful with it!!! Account codes should not be treated loosly!</p>
        <div class="code-box"></div>
        <div class="code-details"></div>
        <div class="create-code-container">
            <input class="create-code-amount" placeholder="Codeamount">
            <input class="create-code-purpose" placeholder="Codepurpose, f.e. 5d">
            <div>
                <button class="create-code-create">Start</button>
                <button class="create-code-cancel">Cancel</button>
            </div>
        </div>
        <div class="code-new-list"></div>
        `);

    document.querySelector(".chart-gallery-left").addEventListener("click", (e) => {
        chart_current += -1;
        if (chart_current < 0) {
            chart_current = chart_name_list.length - 1;
        }
        set_chart_in_gallery();
    })
    document.querySelector(".chart-gallery-right").addEventListener("click", (e) => {
        chart_current += 1;
        if (chart_current > chart_name_list.length - 1) {
            chart_current = 0;
        }
        set_chart_in_gallery();
    })
    document.querySelectorAll(".chart-gallery-number").forEach((element, index) => {element.addEventListener("keyup", (e) => {
        graph_settings_changed();
    })});

    setup_graphs();
    setup_codes();
}