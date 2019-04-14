function load() {
    
    var fullname = document.getElementById("fullname");
    var mail = document.getElementById("mail");
    var save = document.getElementById("save");
    var list = document.getElementById("list");
    var man = document.getElementById("man");
    var woman = document.getElementById("woman");

    list.onclick = function () {

        var temp = man.innerHTML;
        man.innerHTML = woman.innerHTML;
        woman.innerHTML = temp;

    }

    save.onclick = function () {

        

        if (sex.checked) {
            var table = document.getElementById("man");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = fullname.value;
            cell2.innerHTML = mail.value;
        }else{
            var table = document.getElementById("woman");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            cell1.innerHTML = fullname.value;
            cell2.innerHTML = mail.value;
        }


/*
        var newRow = document.createElement('tr');
        var tdname = document.createElement('td'); 
        tdname.value = fullname;
        var tdmail = document.createElement('td'); 
        tdmail.value = mail;
        var tdsex = document.createElement('td'); 
        tdsex.value = "Erkek";
        newRow.appendChild(tdname);
        newRow.appendChild(tdmail);
        newRow.appendChild(tdsex);


        
        */

    };
}


