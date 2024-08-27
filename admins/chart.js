// function canvasData() {
//   let xml = new XMLHttpRequest();
//   xml.open("GET", "./api_canvas/canvas_Category.php", true);
//   xml.onload = function () {
//     if (this.status == 200) {
//       try {
//         let response = JSON.parse(this.responseText);
//         document.getElementById(
//           "main"
//         ).innerHTML = `<canvas id="canvas1"></canvas>
//         `;
//         let arr = [];
//         let categoryname = [];

//         for (let key in response) {
//           arr.push(response[key]);
//           categoryname.push(arr[2]);
//         }
//         var names = [];
//         var numbers = [];

//         arr[2].forEach((element) => {
//           names.push(element.category_name);
//           numbers.push(element.product);
//         });

//         names;
//         numbers;
//         var barColors = [
//           "red",
//           "green",
//           "blue",
//           "orange",
//           "brown",
//           "purple",
//           "yellow",
//           "pink",
//           "cyan",
//           "magenta",
//         ];

//         new Chart("canvas1", {
//           type: "pie",
//           data: {
//             labels: names,
//             datasets: [
//               {
//                 backgroundColor: barColors,
//                 data: numbers,
//               },
//             ],
//           },
//           options: {
//             title: {
//               display: true,
//               text: "Product Distribution by Category",
//             },
//           },
//         });

//         if (response.data && Array.isArray(response.data)) {
//         } else {
//           document.getElementById(
//             "content"
//           ).innerHTML = `<h3>No se encontraron elementos</h3>`;
//         }
//       } catch (e) {
//         console.error("Error al analizar JSON:", e);
//         document.getElementById(
//           "content"
//         ).innerHTML = `<h3>Error al analizar JSON</h3>`;
//       }
//     } else {
//       document.getElementById(
//         "content"
//       ).innerHTML = `<h3>Fallo al cargar los datos</h3>`;
//     }
//   };

//   xml.onerror = function () {
//     let mainElement = document.getElementById("main");
//     if (mainElement) {
//       mainElement.innerHTML = `<h3>Fallo en la solicitud</h3>`;
//     } else {
//       console.error("No se encontró el elemento con ID 'main'");
//     }
//   };

//   xml.send();
// }
function canvasData(source, canvas, id, xValues, yValues, type) {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api_canvas/" + source + ".php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);
        document.getElementById("main").innerHTML = `
        ${canvas}
        `;

        let arr = [];
        let categoryname = [];

        for (let key in response) {
          arr.push(response[key]);
          categoryname.push(arr[2]);
        }
        var names = [];
        var numbers = [];

        arr[2].forEach((element) => {
          console.log(element);

          names.push(element[xValues]);
          numbers.push(element[yValues]);
        });
        console.log(names);

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

        new Chart(`${id}`, {
          type: `${type}`,
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
          ).innerHTML = `<h3>No element found</h3>`;
        }
      } catch (e) {
        console.error("Failed to parse JSON:", e);
        document.getElementById(
          "content"
        ).innerHTML = `<h3>Failed to parse JSON</h3>`;
      }
    } else {
      document.getElementById(
        "content"
      ).innerHTML = `<h3>Failed to load the element</h3>`;
    }
  };

  xml.onerror = function () {
    let mainElement = document.getElementById("main");
    if (mainElement) {
      mainElement.innerHTML = `<h3>Request failed</h3>`;
    } else {
      console.error("No se encontró el elemento con ID 'main'");
    }
  };

  xml.send();
}

canvasData(
  "canvas_Category",
  '<canvas id="canvas1" style="width:100px;max-width:700px"></canvas>',
  "canvas1",
  `category_name`,
  "product",
  "doughnut"
);

canvasData(
  "canvas_Category",
  '<canvas id="canvas1" style="width:100px;max-width:700px"></canvas>',
  "canvas1",
  `category_name`,
  "product",
  "doughnut"
);

document.getElementById("dashboard").addEventListener("click", function () {
  canvasData(
    "canvas_Category",
    '<canvas id="canvas1" style="width:100px;max-width:700px"></canvas>',
    "canvas1",
    `category_name`,
    "product",
    "doughnut"
  );
  canvasData(
    "canvas_Category",
    '<canvas id="canvas1" style="width:100px;max-width:700px"></canvas>',
    "canvas1",
    `category_name`,
    "product",
    "doughnut"
  );
});
