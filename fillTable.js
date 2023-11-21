console.log('fillTable.js Linked');

document.addEventListener("DOMContentLoaded", function () {
    // Get the table element
    var table = document.querySelector("table");

    // Fetch data from the text file
    fetch("todolist.txt")
        .then(response => response.text())
        .then(data => {
            // Split the data into an array of tasks
            var tasks = data.split('\n');

            // Iterate through the tasks and add them to the table
            tasks.forEach(function (task) {
                if (task.trim() !== "") { // Ignore empty lines
                    var row = table.insertRow();
                    var cell = row.insertCell(0);
                    cell.textContent = task;
                }
            });
        })
        .catch(error => console.error("Error fetching data:", error));
});
