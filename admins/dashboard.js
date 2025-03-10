function products(e) {
  e.preventDefault();
  fetch("products");
}
function orders(e) {
  e.preventDefault();
  fetch("orders");
}
function users(e) {
  e.preventDefault();
  fetch("user");
}
function discounts(e) {
  e.preventDefault();
  fetch("discount");
}
function reviews(e) {
  e.preventDefault();
  fetch("reviews");
}
function categories(e) {
  e.preventDefault();
  fetch("categories");
}

document.getElementById("products").addEventListener("click", products);
document.getElementById("orders").addEventListener("click", orders);
document.getElementById("users").addEventListener("click", users);
document.getElementById("discounts").addEventListener("click", discounts);
document.getElementById("categories").addEventListener("click", categories);
document.getElementById("reviews").addEventListener("click", reviews);

function fetch(source = "products", category = "") {
  let xml = new XMLHttpRequest();
  xml.open("GET", "./api/api_" + source + ".php", true);
  xml.onload = function () {
    if (this.status == 200) {
      try {
        let response = JSON.parse(this.responseText);
        // Check if the response has a data property and if it's an array
        if (response.data && Array.isArray(response.data)) {
          let elements = response.data;

          if (category) {
            elements = elements.filter(
              (product) => product.category_name === category
            );
          }
          let tableElement = document.getElementById("main");
          let createdBtn = document.getElementById("createdBtn");
          tableElement.innerHTML = "";

          if (tableElement) {
            if (source == "products") {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./products/create.php">Create New Product</a>`;
              let dropdownContent = "";
              let uniqueCategories = new Set();
              for (const val of elements) {
                if (!uniqueCategories.has(val.category_name)) {
                  uniqueCategories.add(val.category_name);
                  dropdownContent += `<li><a class="dropdown-item" href="#" data-category="${val.category_name}">${val.category_name}</a></li>`;
                }
              }
              let tableContent = `
              <table class='table table-striped table-hover'>
                <thead class='table-dark'>
                  <tr>
                    <th class="text-center" scope='col'>Product Image</th>
                    <th class="text-center" scope='col'>Id</th>
                    <th class="text-center" scope='col'>Product Name</th>
                    <th class="text-center" scope='col'>Price</th>
                    <th class="text-center" scope='col'>Category</th>
                    <th class="text-center" scope='col'>Discount</th>
                    <th class="text-center" scope='col'>Availability</th>
                    <th class="text-center" scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody class='border border-5'>
            `;

              for (const val of elements) {
                let availability =
                  val.availability == 1
                    ? `<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>`
                    : `<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">`;

                tableContent += `
                <tr>
                  <td class="text-center"><img src='../images/${val.image}' alt='${val.product_name}' class='img-thumbnail' style='width: 50px; height: 50px;'></td>
                  <td class="text-center prodClass">${val.product_id}</td>
                  <td class="text-center">${val.product_name}</td>
                  <td class="text-center">€${val.price}</td>
                  <td class="text-center">${val.category_name}</td>
                  <td class="text-center">${val.discount_name}</td>
                  <td class="text-center">
                    <div class="form-check form-switch">
                      ${availability}
                    </div>
                  </td>
                  <td class="text-center">
                    <a href='./products/update.php?id=${val.product_id}' class='btn btn-outline-dark btn-sm'>Update</a>
                    <a class='btn btn-outline-danger btn-sm' href='./products/delete.php?id=${val.product_id}' >Delete</a>
                  </td>
                </tr>
              `;
              }

              tableContent += `
                </tbody>
              </table>
            `;
              tableElement.innerHTML = `
              <ul class="nav nav-tabs">
                  <li class="nav-item">
                      <a id="allProductsBtn" class="nav-link " aria-current="page" href="#">All Product</a>
                  </li>
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu">
                      ${dropdownContent}
                    </ul>
                  </li>
              </ul>
                ${tableContent} `;
              document
                .getElementById("allProductsBtn")
                .addEventListener("click", function (e) {
                  e.preventDefault();
                  fetch("products");
                });
              const dropdownItems = document.querySelectorAll(".dropdown-item");
              dropdownItems.forEach((item) => {
                item.addEventListener("click", function (e) {
                  e.preventDefault();
                  const category = this.getAttribute("data-category");
                  fetch("products", category);
                });
              });
              let checkClass = document.querySelectorAll(".form-check-input");
              let prodClass = document.querySelectorAll(".prodClass");
              checkClass.forEach((element, index) => {
                element.addEventListener("change", function () {
                  checkAction(prodClass[index].innerHTML, element);
                });
              });
            } else if (source == "orders") {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./orders/create.php">Create New Orders</a>`;
              let tableContent = `
              <table class='table table-striped table-hover'>
                <thead class='table-dark'>
                  <tr>
                    <th class="text-center" scope='col'>#</th>
                    <th class="text-center" scope='col'>Total Amount</th>
                    <th class="text-center" scope='col'>Order Status</th>
                    <th class="text-center" scope='col'>Products</th>
                    <th class="text-center" scope='col'>created</th>
                    <th class="text-center" scope='col'>updated</th>
                    <th class="text-center" scope='col'>user</th>
                    <th class="text-center" scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody class='border border-5'>
            `;

              for (const val of elements) {
                tableContent += `
                <tr>
                  <td class="text-center">${val.order_id}</td>
                  <td class="text-center">${val.total_amount}</td>
                  <td class="text-center">${val.order_status}</td>
                  <td class="text-center">${val.products}</td>
                  <td class="text-center">${val.created_at}</td>
                  <td class="text-center">${val.updated_at}</td>
                  <td class="text-center">${val.user_id}</td>
                  <td class="text-center">
                    <a href='./orders/update.php?id=${val.order_id}' class='btn btn-outline-dark btn-sm'>Update</a>
                    <a href='./orders/delete.php?id=${val.order_id}' class='btn btn-outline-danger btn-sm'>Delete</a>
                  </td>
                </tr>
              `;
              }

              tableContent += `
                </tbody>
              </table>
            `;

              tableElement.innerHTML = tableContent;
            } else if (source == "user") {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./users/create.php">Create New User</a>`;
              for (const val of elements) {
              }
              let tableContent = `
              <table class='table table-striped table-hover'>
                <thead class='table-dark'>
                  <tr>
                    <th class="text-center" scope='col'>#</th>
                    <th class="text-center" scope='col'>Username</th>
                    <th class="text-center" scope='col'>Email</th>
                    <th class="text-center" scope='col'>First Name</th>
                    <th class="text-center" scope='col'>Last Name</th>
                    <th class="text-center" scope='col'>Image</th>
                    <th class="text-center" scope='col'>Role</th>
                    <th class="text-center" scope='col'>Status</th>
                    <th class="text-center" scope='col'>Ban Time</th>                    
                    <th class="text-center" scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody class='border border-5'>
            `;

              for (const val of elements) {
                let dateBan = "";
                let status =
                  val.status == 1
                    ? `<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>`
                    : `<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">`;
                if (val.status == 1) {
                  tr = `bg-danger`;
                  dateBan = `
                             <td class="banTd ${tr}"><input type="datetime-local" class="banTime" id="banTime" value="${val.timeBan}" name="banTime"></td>
                            `;
                } else {
                  tr = ` text-black`;
                  dateBan = `<td><input type="datetime-local" class="banTime" id="banTime" name="banTime" disabled></td>`;
                }

                tableContent += `
                <tr>
                  <td class="text-center  ${tr} prodClass">${val.user_id}</td>
                  <td class="text-center ${tr}">${val.username}</td>
                  <td class="text-center ${tr}">${val.email}</td>
                  <td class="text-center ${tr}">${val.first_name}</td>
                  <td class="text-center ${tr}">${val.last_name}</td>
                  <td class="text-center ${tr}">
                    <img src='../images/${val.image}' alt='${val.username}' class='img-thumbnail ${tr}' style='width: 50px; height: 50px;'>
                  </td>
                  <td class="text-center ${tr}">${val.role}</td>
                  <td class="text-center ${tr}">
                    <div class="form-check form-switch">
                      ${status}
                  </td>
                  ${dateBan}
                  <td class="text-center">
                    <a href='./users/update.php?id=${val.user_id}' class='btn btn-outline-dark btn-sm'>Update</a>
                    <a href='./users/delete.php?id=${val.user_id}' class='btn btn-outline-danger btn-sm'>Delete</a>
                  </td>
                </tr>
              `;
              }

              tableContent += `
                </tbody>
              </table>
            `;
              tableElement.innerHTML = tableContent;
              let checkClass = document.querySelectorAll(".form-check-input");
              let prodClass = document.querySelectorAll(".prodClass");
              checkClass.forEach((element, index) => {
                element.addEventListener("change", function () {
                  checkAction2(prodClass[index].innerHTML, element);
                  if (checkClass[index].checked) {
                    checkClass[index].classList.add("bg-warning");
                  } else {
                    checkClass[index].classList.remove("bg-warning");
                  }
                });
              });

              let checkClass1 = document.querySelectorAll(".banTime");

              let prodClass1 = document.querySelectorAll(".prodClass");

              checkClass1.forEach((element, index) => {
                element.addEventListener("change", function () {
                  checkAction3(prodClass1[index].innerHTML, element.value);
                  prodClass1[index].classList.add("bg-danger");
                });
              });
            } else if (source == "discount") {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./discount/create.php">Create New Discount</a>`;
              let tableContent = `
              <table class='table table-striped table-hover'>
                <thead class='table-dark'>
                  <tr>
                    <th class="text-center" scope='col'>#</th>
                    <th class="text-center" scope='col'>Discount Name</th>
                    <th class="text-center" scope='col'>Discount ID</th>
                    <th class="text-center" scope='col'>Discount Percentage</th>
                    <th class="text-center" scope='col'>Start Date</th>
                    <th class="text-center" scope='col'>End Date</th>
                    <th class="text-center" scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody class='border border-5'>
            `;

              for (const val of elements) {
                tableContent += `
                <tr>
                  <td class="text-center">${val.discount_id}</td>
                  <td class="text-center">${val.discount_name}</td>
                  <td class="text-center">${val.discount_id}</td>
                  <td class="text-center">${val.discount_percentage}%</td>
                  <td class="text-center">${val.start_date}</td>
                  <td class="text-center">${val.end_date}</td>
                  <td class="text-center">
                    <a href='./discount/update.php?id=${val.discount_id}' class='btn btn-outline-dark btn-sm'>Update</a>
                    <a href='./discount/delete.php?id=${val.discount_id}' class='btn btn-outline-danger btn-sm'>Delete</a>
                  </td>
                </tr>
              `;
              }

              tableContent += `
                </tbody>
              </table>
            `;

              tableElement.innerHTML = tableContent;
            } else if (source == "reviews") {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./reviews/create.php">Create New Review</a>`;
              let tableContent = `
    <table class='table table-striped table-hover'>
      <thead class='table-dark'>
        <tr>
          <th class="text-center" scope='col'>#</th>
          <th class="text-center" scope='col'>Product ID</th>
          <th class="text-center" scope='col'>User ID</th>
          <th class="text-center" scope='col'>Rating</th>
          <th class="text-center" scope='col'>Comment</th>
          <th class="text-center" scope='col'>Created At</th>
          <th class="text-center" scope='col'>Updated At</th>
          <th class="text-center" scope='col'>Actions</th>
        </tr>
      </thead>
      <tbody class='border border-5'>
  `;

              for (const val of elements) {
                tableContent += `

      <tr >
        <td class="text-center">${val.review_id}</td>
        <td class="text-center">${val.product_id}</td>
        <td class="text-center">${val.user_id}</td>
        <td class="text-center">${val.rating}</td>
        <td class="text-center">${val.comment}</td>
        <td class="text-center">${val.created_at}</td>
        <td class="text-center">${val.updated_at}</td>
        <td class="text-center">
          <a href='./reviews/update.php?id=${val.review_id}' class='btn btn-outline-dark btn-sm'>Update</a>
          <a href='./reviews/delete.php?id=${val.review_id}' class='btn btn-outline-danger btn-sm'>Delete</a>
        </td>
      </tr>
    `;
              }

              tableContent += `
      </tbody>
    </table>
  `;

              tableElement.innerHTML = tableContent;
            } else {
              createdBtn.innerHTML = `<a class="btn btn-success" href="./category/create.php">Create New Category</a>`;
              let tableContent = `
              <table class='table table-striped table-hover'>
                <thead class='table-dark'>
                  <tr>
                    <th class="text-center" scope='col'>#</th>
                    <th class="text-center" scope='col'>Category ID</th>
                    <th class="text-center" scope='col'>Category Name</th>
                    <th class="text-center" scope='col'>Actions</th>
                  </tr>
                </thead>
                <tbody class='border border-5'>
            `;

              for (const val of elements) {
                tableContent += `
                <tr>
                  <td class="text-center">${val.category_id}</td>
                  <td class="text-center">${val.category_id}</td>
                  <td class="text-center">${val.category_name}</td>
                  <td class="text-center">
                    <a href='./category/update.php?id=${val.category_id}' class='btn btn-outline-dark btn-sm'>Update</a>
                    <a href='./category/delete.php?id=${val.category_id}' class='btn btn-outline-danger btn-sm'>Delete</a>
                  </td>
                </tr>
              `;
              }

              tableContent += `
                </tbody>
              </table>
            `;

              tableElement.innerHTML = tableContent;
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

function checkAction(index) {
  let xml = new XMLHttpRequest();

  xml.onload = function () {
    if (this.status == 200) {
      // action
    }
  };

  xml.open("GET", "./api/api_product_status.php?id=" + index);

  xml.send();
}
function checkAction2(index) {
  let xml = new XMLHttpRequest();

  xml.onload = function () {
    if (this.status == 200) {
      // action
    }
  };
  xml.open("GET", "./api/api_user_status.php?id=" + index);

  xml.send();
}
function checkAction3(index, element) {
  let xml = new XMLHttpRequest();

  xml.onload = function () {
    if (this.status == 200) {
    }
  };

  xml.open("GET", "./api/api_ban_time.php?id=" + index + "&val=" + element);
  console.log(element);

  xml.send();
}

function deleteElement() {
  Swal.fire({
    title: "Are you sure?",
    text: "You won't be able to revert this!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "Deleted!",
        text: "Your file has been deleted.",
        icon: "success",
      });
    }
  });
}
