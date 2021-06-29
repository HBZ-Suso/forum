var table_current = 0;





function table_left () {
    table_current -= 1;
    
    if (table_current < 0) {
        table_current = document.querySelector(".table-container").children.length - 1;
    }

    document.querySelectorAll(".table-table").forEach((element, index) => {element.style.display = "none";})
    document.querySelector(".table-" + table_current).style.display = "";
}

function table_right () {
    table_current += 1;
    
    if (table_current > document.querySelector(".table-container").children.length - 1) {
        table_current = 0;
    }

    document.querySelectorAll(".table-table").forEach((element, index) => {element.style.display = "none";})
    document.querySelector(".table-" + table_current).style.display = "";
}

window.addEventListener("load", (e) => {
    if (document.querySelector(".table-container") === undefined || document.querySelector(".table-container") === null) {return;}

    //define some sample data
    var table_0_data = [
        {id:1, name:"Oli Bob", age:"12", col:"red", dob:""},
        {id:2, name:"Mary May", age:"1", col:"blue", dob:"14/05/1982"},
        {id:3, name:"Christine Lobowski", age:"42", col:"green", dob:"22/05/1982"},
        {id:4, name:"Brendon Philips", age:"125", col:"orange", dob:"01/08/1980"},
        {id:5, name:"Margret Marmajuke", age:"16", col:"yellow", dob:"31/01/1999"},
    ];

    //create Tabulator on DOM element with id "example-table"
    var table_1 = new Tabulator("#table-0", {
        ajaxURL: "/forum/v2/assets/",
        height: 500, // set height of table (in CSS or here), this enables the Virtual DOM and improves render speed dramatically (can be any valid css height value)
        data:table_0_data, //assign data to table
        layout:"fitColumns", //fit columns to width of table (optional)
        columns:[ //Define Table Columns
            {title:"Name", field:"name", width:150},
            {title:"Age", field:"age", hozAlign:"left", formatter:"progress"},
            {title:"Favourite Color", field:"col"},
            {title:"Date Of Birth", field:"dob", sorter:"date", hozAlign:"center"},
        ],
        rowClick:function(e, row){ //trigger an alert message when the row is clicked
            alert("Row " + row.getData().id + " Clicked!!!!");
        },
    });
})

