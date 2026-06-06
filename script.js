function loadData() {

fetch('data.php')
    .then(response => response.json())
    .then(data => {

        let table = document.getElementById('tableData');

        table.innerHTML = '';

        data.forEach(row => {

            table.innerHTML += `
                <tr>
                    <td>${row.NIDN}</td>
                    <td>${row.Name}</td>
                    <td>${row.Major}</td>
                    <td>${row.Course}</td>

                    <td>
                        <button onclick="deleteData('${row.NIDN}')">
                            Delete
                        </button>
                    </td>
                </tr>
            `;

        });

    });

}

function loadStudentData() {

    fetch('sd.php')
        .then(response => response.json())
        .then(data => {

            console.log(data);

            alert("Jumlah data student: " + data.length);

            let table = document.getElementById('studentTable');

            table.innerHTML = '';

            data.forEach(row => {

                table.innerHTML += `
                    <tr>
                        <td>${row.ID}</td>
                        <td>${row.Name}</td>
                        <td>${row.Major}</td>
                        <td>${row.Class}</td>
                        <td>${row.Hobby}</td>
                    </tr>
                `;

            });

        });

}

loadData();
loadStudentData();
alert("Student Function Called");

document.getElementById('lecturerForm')
.addEventListener('submit', function(e) {

    e.preventDefault();

    let formData = new FormData(this);

    fetch('add.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {

        if(result.trim() === "duplicate"){
            alert("NIDN already exists!");
        } else {
            showNotification("Data has been added successfully!");
            this.reset();
            loadData();
        }

    });

});


function deleteData(nidn) {

if (confirm('Delete this data?')) {

    fetch('delete.php?nidn=' + nidn)
        .then(response => response.text())
        .then(result => {

            showNotification("Data has been deleted successfully!");

            loadData();

        });

}

}

function showNotification(message) {
    let notif = document.getElementById("notification");

    notif.innerText = message;
    notif.style.display = "block";

    setTimeout(() => {
        notif.style.display = "none";
    }, 2000);
}