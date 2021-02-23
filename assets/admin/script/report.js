var report_container = document.querySelector("report-container");

var space = parseInt(document.getElementById("report-show-size").value);
var start_show = parseInt(document.getElementById("report-start-field").value);
var set_column = document.getElementById("report-set-field").value;
var set_to = document.getElementById("report-to").value;

var set_reports = function (data) {
    document.querySelector(".report-d-container").innerHTML = "";
    data.forEach((element, index) => {
        document.querySelector(".report-d-container").innerHTML += `<tr><td><div class="table-scroll">${element["reportId"]}</div></td><td><div class="table-scroll">${element["reportTitle"]}</div></td><td><div class="table-scroll">${element["reportDate"]}</div></td><td><div class="table-scroll">${element["reportIp"]}</div></td><td><div class="table-scroll">${element["userId"]}</div></td><td><a class="view-report-button" href="/forum/assets/admin/view_report.php?reportId=${element["reportId"]}">View</a></td></tr>`;
    })
}

axios
    .post("/forum/assets/admin/api/get_reports.php?min=" + start_show + "&max=" + (start_show + space) + "&field=" + set_column + "&to=" + set_to)
    .then((resolve) => {
        set_reports(resolve.data)
    }, (reject) => {console.log(reject)})
    .catch((error) => (console.log(error)))


document.getElementById("report-submit").addEventListener("click", (e) => {
    space = parseInt(document.getElementById("report-show-size").value);
    start_show = parseInt(document.getElementById("report-start-field").value);
    set_column = document.getElementById("report-set-field").value;
    set_to = document.getElementById("report-to").value;
    axios
        .post("/forum/assets/admin/api/get_reports.php?min=" + start_show + "&max=" + (start_show + space) + "&field=" + set_column + "&to=" + set_to)
        .then((resolve) => {
            set_reports(resolve.data)
        }, (reject) => {console.log(reject)})
        .catch((error) => (console.log(error)))
})





const report_table = document.querySelector('.report-container'); //get the table to be sorted

report_table.querySelectorAll('th') // get all the table header elements
  .forEach((element, columnNo)=>{ // add a click handler for each 
    element.addEventListener('click', event => {
        report_sortTable(report_table, columnNo); //call a function which sorts the table by a given column number
    })
})

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function report_sortTable(table, sortColumn){
    // get the data from the table cells
    const report_tableBody = table.querySelector('tbody')
    const report_tableData = table2data(report_tableBody);
    // sort the extracted data
    tableData.sort((a, b)=>{
        let new_a = a[sortColumn].replace('<div class="table-scroll">', "").replace("</div>", "");
        let new_b = b[sortColumn].replace('<div class="table-scroll">', "").replace("</div>", "");
        if (isNumeric(new_a) && isNumeric(new_b)) {
            if(parseFloat(new_a) > parseFloat(new_b)){
                return 1;
            }
            return -1;
        } else {
            if(new_a > new_b){
                return 1;
            }
            return -1;
        }
    })
    // put the sorted data back into the table
    data2table(report_tableBody, report_tableData);
}
  
// this function gets data from the rows and cells 
// within an html tbody element
function report_table2data(report_tableBody){
    const report_tableData = []; // create the array that'll hold the data rows
    report_tableBody.querySelectorAll('tr')
        .forEach(row=>{  // for each table row...
            const report_rowData = [];  // make an array for that row
            row.querySelectorAll('td')  // for each cell in that row
            .forEach(cell=>{
                report_rowData.push(cell.innerHTML);  // add it to the row data
            })
            report_tableData.push(report_rowData);  // add the full row to the table data 
        });
    return report_tableData;
}
  
// this function puts data into an html tbody element
function report_data2table(tableBody, tableData){
    tableBody.querySelectorAll('tr') // for each table row...
        .forEach((row, i)=>{  
            const report_rowData = tableData[i]; // get the array for the row data
            row.querySelectorAll('td')  // for each table cell ...
            .forEach((cell, j)=>{
                cell.innerHTML = report_rowData[j]; // put the appropriate array element into the cell
            })
        tableData.push(report_rowData);
    });
}
  