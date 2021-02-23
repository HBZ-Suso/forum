var visitor_container = document.querySelector("visitor-container");

var space = parseInt(document.getElementById("visit-show-size").value);
var start_show = parseInt(document.getElementById("visit-start-field").value);
var set_column = document.getElementById("visit-set-field").value;
var set_to = document.getElementById("visit-to").value;

var set_visitors = function (data) {
    document.querySelector(".visitor-d-container").innerHTML = "";
    data.forEach((element, index) => {
        document.querySelector(".visitor-d-container").innerHTML += `<tr><td><div class="table-scroll">${element["visitId"]}</div></td><td><div class="table-scroll">${element["userId"]}</div></td><td><div class="table-scroll">${element["visitIp"]}</div></td><td><div class="table-scroll">${element["visitPage"]}</div></td><td><div class="table-scroll">${element["visitDate"]}</div></td><td><div class="table-scroll">${element["visitData"]}</div></td><td><div class="table-scroll">${element["visitUserAgent"]}</div></td></tr>`;
    })
}

axios
    .post("/forum/assets/admin/api/get_visitors.php?min=" + start_show + "&max=" + (start_show + space) + "&field=" + set_column + "&to=" + set_to)
    .then((resolve) => {
        set_visitors(resolve.data)
    }, (reject) => {console.log(reject)})
    .catch((error) => (console.log(error)))


document.getElementById("visit-submit").addEventListener("click", (e) => {
    space = parseInt(document.getElementById("visit-show-size").value);
    start_show = parseInt(document.getElementById("visit-start-field").value);
    set_column = document.getElementById("visit-set-field").value;
    set_to = document.getElementById("visit-to").value;
    axios
        .post("/forum/assets/admin/api/get_visitors.php?min=" + start_show + "&max=" + (start_show + space) + "&field=" + set_column + "&to=" + set_to)
        .then((resolve) => {
            set_visitors(resolve.data)
        }, (reject) => {console.log(reject)})
        .catch((error) => (console.log(error)))
})





const visitor_table = document.querySelector('.visitor-container'); //get the table to be sorted

visitor_table.querySelectorAll('th') // get all the table header elements
  .forEach((element, columnNo)=>{ // add a click handler for each 
    element.addEventListener('click', event => {
        visitor_sortTable(visitor_table, columnNo); //call a function which sorts the table by a given column number
    })
})

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function visitor_sortTable(table, sortColumn){
    // get the data from the table cells
    const visitor_tableBody = visitor_table.querySelector('tbody')
    const visitor_tableData = visitor_table2data(visitor_tableBody);
    // sort the extracted data
    visitor_tableData.sort((a, b)=>{
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
    visitor_data2table(visitor_tableBody, visitor_tableData);
}
  
// this function gets data from the rows and cells 
// within an html tbody element
function visitor_table2data(visitor_tableBody){
    const visitor_tableData = []; // create the array that'll hold the data rows
    visitor_tableBody.querySelectorAll('tr')
        .forEach(row=>{  // for each table row...
            const rowData = [];  // make an array for that row
            row.querySelectorAll('td')  // for each cell in that row
            .forEach(cell=>{
                rowData.push(cell.innerHTML);  // add it to the row data
            })
            visitor_tableData.push(rowData);  // add the full row to the table data 
        });
    return visitor_tableData;
}
  
// this function puts data into an html tbody element
function visitor_data2table(visitor_tableBody, visitor_tableData){
    visitor_tableBody.querySelectorAll('tr') // for each table row...
        .forEach((row, i)=>{  
            const rowData = visitor_tableData[i]; // get the array for the row data
            row.querySelectorAll('td')  // for each table cell ...
            .forEach((cell, j)=>{
                cell.innerHTML = rowData[j]; // put the appropriate array element into the cell
            })
            visitor_tableData.push(rowData);
    });
}
  