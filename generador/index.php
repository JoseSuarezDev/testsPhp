<body>
    
    <h1>Generator</h1>
    <form id="form">

    <Table>
        <thead>
            <th>Codigo de la tabla</th>
            <th>Nombre de la tabla</th>
            <th>Observaciones</th>
        </thead>
        <tbody>
            <tr>
                <td><input name="nameTable"></td>
                <td><input name="codeTable"></td>
                <td><input name="observaciones"></td>
            </tr>
            <tr> <td> <h2> Campos </h2> </td> </tr>
            <tr>
                <th>Nombre del campo  (name)</th>
                <th>Null (code)</th>
                <th>tipo de dato (observation)</th>
            </tr>
        </tbody>
    </Table>

        <div>
            <input name='input1' type="text">
            <select name="code1" id="code1">
                <option value="null">null</option>
                <option value="NOT NULL">NOT NULL</option>
            </select>
            <select name="obser1" id="obser1">
                <option value="VARCHAR"> VARCHAR </option>
                <option value="integer"> integer </option>
                <option value="bool"> bool </option>
            </select>
        <input type="button" onclick="createTable(event)" Value="Crear">
        </div>
        <button id="submit" onclick="enviar(event)">Submit</button>

    </form>

    <div id="content"></div>

<script>
count = 1; 
function createTable(event) {
     
    count++ 
    
    let form = document.querySelector('#form');    
    // let formNode = event.target.parentNode;
    let formNode = document.querySelector('#submit').parentNode;
    //input a insertar
    var div = document.createElement("DIV");
    var input = document.createElement("INPUT");
    var code = document.querySelector('#code1').cloneNode(true);
    var observ = document.querySelector('#obser1').cloneNode(true);
    input.setAttribute('name', 'input' + count)
    code.setAttribute('name', 'code' + count)
    observ.setAttribute('name', 'obser' + count)
    div.appendChild(input);
    div.appendChild(code);
    div.appendChild(observ);
    
    // let ref = document.querySelector('#input' + (count-1) ).parentNode;
    let ref = document.querySelector(`input[name='input${count-1}']`).parentNode ;
    form.appendChild(div);
    formNode.insertBefore(div, ref.nextSibling); 
    
}

// Asynchronous JavaScript And XML
function enviar(event) {
    event.preventDefault();

    dataForm = new FormData( document.querySelector('#form') )
    // console.log( ...dataForm.values() )
    // console.log( dataForm.serialize() )

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          document.getElementById("content").innerHTML =
          this.responseText;
        }
    };

    // GET:
    // xhttp.open("GET", "controller.php?id=1", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // xhttp.send();

    // POST:
    xhttp.open("POST", "controller.php", true);
    // xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(dataForm);

}

</script>

</body>
