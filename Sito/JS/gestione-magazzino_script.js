var modalel = document.getElementById("delete");
var span = document.getElementsByClassName("close2")[0];
document.getElementById("btn2").onclick = function deleteProducts() {
    if (document.getElementById('table').rows[0].cells.length == 4) {
        var tr = document.getElementById("title");
        tr.innerHTML = tr.innerHTML + "<th style='background-color: #1260ab;color: #fafafa;font-family: 'Open Sans', Sans-serif;font-weight: 200;text-transform: uppercase;'>CANCELLA</th>";
        var nrow = "<?php echo $i ?>";
        for (var i = 0; i < nrow; i++) {
            var rows = document.getElementById("row" + i);
            rows.innerHTML = rows.innerHTML + "<td> <input type='checkbox' name='" + i + "' /> </td>";
        }
        document.getElementById("btn2").innerHTML = "ELIMINA?";
        document.getElementById("btn").disabled = true;

    } else {
        modalel.style.display = "block";
        let check = new Array();
        for (let o = 0; o < nrow; o++) {
            if (document.getElementById("table").rows[o].cells[4].checked) {
                console.log("presop");
            }
        }
    }
}
span.onclick = function () {
    modalel.style.display = "none";
    var rows2 = document.getElementById('table').rows;
    for (var l = 0; l < rows2.length; l++) {
        rows2[l].deleteCell(4);
    }
    document.getElementById("btn").disabled = false;
}
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}