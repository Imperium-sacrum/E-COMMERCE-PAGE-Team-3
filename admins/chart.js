function canvasData() {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api_canvas/canvas_Category.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);

        let arr = [];
        let categoryname = [];

        for (let key in response) {
          arr.push(response[key]);
          categoryname.push(arr[2]);
        }
        var names = [];
        var numbers = [];

        console.log(arr[2]);
        arr[2].forEach((element) => {
          names.push(element.category_name);
          numbers.push(element.product);
        });

        names;
        numbers;
        var barColors = [
          "red",
          "green",
          "blue",
          "orange",
          "brown",
          "purple",
          "yellow",
          "pink",
          "cyan",
          "magenta",
        ];

        new Chart("content", {
          type: "pie",
          data: {
            labels: names,
            datasets: [
              {
                backgroundColor: barColors,
                data: numbers,
              },
            ],
          },
          options: {
            title: {
              display: true,
              text: "Product Distribution by Category",
            },
          },
        });

        if (response.data && Array.isArray(response.data)) {
        } else {
          document.getElementById(
            "content"
          ).innerHTML = `<h3>No se encontraron elementos</h3>`;
        }
      } catch (e) {
        console.error("Error al analizar JSON:", e);
        document.getElementById(
          "content"
        ).innerHTML = `<h3>Error al analizar JSON</h3>`;
      }
    } else {
      document.getElementById(
        "content"
      ).innerHTML = `<h3>Fallo al cargar los datos</h3>`;
    }
  };

  xml.onerror = function () {
    let mainElement = document.getElementById("main");
    if (mainElement) {
      mainElement.innerHTML = `<h3>Fallo en la solicitud</h3>`;
    } else {
      console.error("No se encontró el elemento con ID 'main'");
    }
  };

  xml.send();
}
canvasData();
