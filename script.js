document.getElementById("create-button").addEventListener("click", () => sendData("create"));
document.getElementById("read-button").addEventListener("click", () => sendData("read"));
document.getElementById("update-button").addEventListener("click", () => sendData("update"));
document.getElementById("delete-button").addEventListener("click", () => sendData("delete"));

function sendData(action) {
    const data = new FormData();
    data.append("action", action);
    data.append("product-id", document.getElementById("product-id").value);
    data.append("product-name", document.getElementById("product-name").value);
    data.append("product-description", document.getElementById("product-description").value);
    data.append("product-price", document.getElementById("product-price").value);

    fetch("http://localhost/AWS/crud.php", {
        method: "POST",
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
        if (action === "read") {
            const productList = document.getElementById("product-list");
            productList.innerHTML = "";
            data.forEach(product => {
                const li = document.createElement("li");
                li.textContent = `ID: ${product.ID_producto}, Nombre: ${product.Nombre}, Descripción: ${product.Descripcion}, Precio: ${product.Precio}`;
                productList.appendChild(li);
            });
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
}
