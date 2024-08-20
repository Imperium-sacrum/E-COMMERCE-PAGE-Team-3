/* globals Chart:false */

(() => {
  "use strict";

  // Graphs
  const ctx = document.getElementById("myChart");
  // eslint-disable-next-line no-unused-vars
  const myChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: [
        "Sunday",
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
      ],
      datasets: [
        {
          data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
          lineTension: 0,
          backgroundColor: "transparent",
          borderColor: "#007bff",
          borderWidth: 4,
          pointBackgroundColor: "#007bff",
        },
      ],
    },
    options: {
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          boxPadding: 3,
        },
      },
    },
  });
})();

function products() {
  fetch("products");
}
function orders() {
  fetch("orders");
}
function users() {
  fetch("user");
}
function discounts() {
  fetch("discount");
}
function reviews() {
  fetch("reviews");
}

document.getElementById("products").addEventListener("click", products);
document.getElementById("orders").addEventListener("click", orders);
document.getElementById("users").addEventListener("click", users);
document.getElementById("discounts").addEventListener("click", discounts);
document.getElementById("reviews").addEventListener("click", reviews);

function fetch(source = "products") {
  let xml = new XMLHttpRequest();
  xml.open(
    "GET",
    "http://localhost:3000/admins/api/api_" + source + ".php",
    true
  );
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);
        // Check if the response has a data property and if it's an array
        if (response.data && Array.isArray(response.data)) {
          let elements = response.data;
          let tableElement = document.getElementById("main");

          // Ensure table element exists before modifying it
          if (tableElement) {
            for (let val of elements) {
              tableElement.innerHTML += `
      <tr>
        <td>${val.product_id}</td>
        <td>${val.product_name}</td>
        <td>${val.description}</td>
        <td>${val.price}</td>
        <td>${val.category_id}</td>
        <td>${val.discount_id}</td>
        <td><img src="../images/${val.image}" alt="${val.product_name}" class="img-fluid" style="max-width: 100px;"></td>
      </tr>
              `;
            }
          } else {
            console.error("Element with ID 'table' not found");
          }
        } else {
          document.getElementById(
            "main"
          ).innerHTML = `<h3>No element found</h3>`;
        }
      } catch (e) {
        console.error("JSON parsing error:", e);
        document.getElementById(
          "main"
        ).innerHTML = `<h3>Failed to parse JSON</h3>`;
      }
    } else {
      document.getElementById(
        "main"
      ).innerHTML = `<h3>Failed to load the element</h3>`;
    }
  };

  xml.onerror = function () {
    let hiElement = document.getElementById("main");
    if (hiElement) {
      hiElement.innerHTML = `<h3>Request failed</h3>`;
    } else {
      console.error("Element with ID 'hi' not found");
    }
  };

  xml.send();
}
