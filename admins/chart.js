function canvasData() {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api_canvas/canvas_Category.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);
        document.getElementById("main").innerHTML = `
  <div class="container d-flex">
    <div class="row">
      <div class="col-md-6">
        <div class="canvas-container">
          <canvas id="canvas1" "></canvas>
        </div>
      </div>
      <div class="col-md-6">
        <div class="canvas-container">
          <canvas id="canvas2" "></canvas>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-md-12 text-center">
        <div class="canvas-container">
          <canvas id="canvas3""></canvas>
        </div>
      </div>
    </div>
  </div>
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
          names.push(element["category_name"]);
          numbers.push(element["product"]);
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

        new Chart("canvas1", {
          type: "doughnut",
          data: {
            labels: names,
            datasets: [
              {
                backgroundColor: barColors,
                data: numbers,
                borderColor: "#fff", // Añade bordes blancos entre las secciones
                borderWidth: 2, // Grosor del borde entre las secciones
                hoverOffset: 10, // Efecto de separación al pasar el ratón
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // Asegura que el gráfico se ajuste al contenedor
            plugins: {
              title: {
                display: true,
                text: "Product Distribution by Category",
                font: {
                  size: 18,
                  weight: "bold",
                  family: "Arial",
                },
                color: "#333",
                padding: {
                  top: 20,
                  bottom: 30,
                },
              },
              legend: {
                display: true,
                position: "bottom", // Coloca la leyenda debajo del gráfico
                labels: {
                  font: {
                    size: 14,
                    family: "Arial",
                  },
                  color: "#333",
                  padding: 20,
                  boxWidth: 15, // Tamaño de las muestras de color en la leyenda
                },
              },
              tooltip: {
                enabled: true,
                backgroundColor: "rgba(0, 0, 0, 0.8)",
                titleFont: {
                  size: 16,
                  family: "Arial",
                  weight: "bold",
                },
                bodyFont: {
                  size: 14,
                  family: "Arial",
                },
                cornerRadius: 4,
                displayColors: true,
                padding: 10,
              },
            },
            cutout: "60%", // Hace la dona más delgada
            animation: {
              animateRotate: true, // Anima la rotación de la dona
              animateScale: true, // Anima la escala de la dona
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
function canvasData2() {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api_canvas/canvas_order.php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);

        let arr = [];
        let categoryname = [];
        const data = {
          numbers: [],
        };
        for (let i = 100; i <= 10000; i += 100) {
          data.numbers.push(i);
        }

        for (let key in response) {
          arr.push(response[key]);
          categoryname.push(arr[2]);
        }
        var xValues = [];
        var yValues = [];

        arr[2].forEach((element) => {
          xValues.push(element["order_date"]);
          yValues.push(element["daily_total"]);
        });

        new Chart("canvas2", {
          type: "line",
          data: {
            labels: xValues,
            datasets: [
              {
                label: "Daily Earnings",
                data: yValues,
                borderColor: "#4B9CD3",
                backgroundColor: "rgba(75, 156, 211, 0.2)",
                borderWidth: 2,
                pointBackgroundColor: "#4B9CD3",
                pointBorderColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointHoverBorderColor: "#4B9CD3",
                tension: 0.3,
                fill: true,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: "Earnings of the Shop per Day",
                font: {
                  size: 18,
                  weight: "bold",
                  family: "Arial",
                },
                color: "#333",
              },
              legend: {
                display: true,
                position: "top",
                labels: {
                  font: {
                    size: 12,
                    family: "Arial",
                  },
                  color: "#333",
                },
              },
              tooltip: {
                enabled: true,
                backgroundColor: "rgba(0,0,0,0.8)",
                titleFont: {
                  size: 14,
                  family: "Arial",
                },
                bodyFont: {
                  size: 12,
                  family: "Arial",
                },
                cornerRadius: 4,
                displayColors: false,
              },
            },
            scales: {
              x: {
                grid: {
                  display: false,
                },
                title: {
                  display: true,
                  text: "Date",
                  font: {
                    size: 14,
                    family: "Arial",
                  },
                  color: "#333",
                },
                ticks: {
                  font: {
                    size: 12,
                    family: "Arial",
                  },
                  color: "#333",
                },
              },
              y: {
                beginAtZero: true,
                grid: {
                  color: "rgba(200, 200, 200, 0.2)",
                },
                title: {
                  display: true,
                  text: "Earnings (EUR)",
                  font: {
                    size: 14,
                    family: "Arial",
                  },
                  color: "#333",
                },
                ticks: {
                  font: {
                    size: 12,
                    family: "Arial",
                  },
                  color: "#333",
                },
                suggestedMin: 0,
                suggestedMax: Math.max(...yValues) + 10,
              },
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
function canvasData3() {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api_canvas/canvas_reviews.php", true);
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
        var xValues = [];
        var yValues = [];
        var barColors = [
          "yellow",
          "green",
          "blue",
          "orange",
          "brown",
          "purple",
          "red",
          "pink",
          "cyan",
          "magenta",
        ];

        arr[2].forEach((element) => {
          xValues.push(element["average_rating"]);
          yValues.push(element["product_name"]);
        });
        new Chart("canvas3", {
          type: "bar",
          data: {
            labels: yValues,
            datasets: [
              {
                backgroundColor: barColors,
                data: xValues,
                borderColor: "#333",
                borderWidth: 1,
                hoverBackgroundColor: "#555",
                hoverBorderColor: "#333",
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false, // Asegura que el gráfico se ajuste al contenedor
            plugins: {
              title: {
                display: true,
                text: "Product Distribution by Category",
                font: {
                  size: 18,
                  weight: "bold",
                  family: "Arial",
                },
                color: "#333",
                padding: {
                  top: 20,
                  bottom: 20,
                },
              },
              legend: {
                display: false,
              },
              tooltip: {
                enabled: true,
                backgroundColor: "rgba(0, 0, 0, 0.8)",
                titleFont: {
                  size: 14,
                  family: "Arial",
                  weight: "bold",
                },
                bodyFont: {
                  size: 12,
                  family: "Arial",
                },
                cornerRadius: 4,
                displayColors: false,
              },
            },
            scales: {
              x: {
                grid: {
                  display: false,
                },
                title: {
                  display: true,
                  text: "Categories",
                  font: {
                    size: 14,
                    family: "Arial",
                  },
                  color: "#333",
                },
                ticks: {
                  font: {
                    size: 12,
                    family: "Arial",
                  },
                  color: "#333",
                },
              },
              y: {
                beginAtZero: true, // Asegura que el eje Y comience en 0
                grid: {
                  color: "rgba(200, 200, 200, 0.2)", // Colores más suaves para la cuadrícula
                },
                title: {
                  display: true,
                  text: "Number of Products",
                  font: {
                    size: 14,
                    family: "Arial",
                  },
                  color: "#333",
                },
                ticks: {
                  font: {
                    size: 12,
                    family: "Arial",
                  },
                  color: "#333",
                },
                suggestedMin: 0,
                suggestedMax: 5,
              },
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

canvasData();
canvasData2();
canvasData3();

document.getElementById("dashboard").addEventListener("click", function () {
  document.getElementById("main").innerHTML = ``;
  canvasData();
  canvasData2();
  canvasData3();
});
