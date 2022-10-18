async function getUsers() {
  document.getElementById("allUsers").innerHTML = ""
  let response = await fetch("http://localhost:8000/index.php/user/list", {
    method: "GET",
    mode: "cors",
    headers: {
      "Content-Type": "application/json",
    },
  });
  let users = await response.json();
  for (let user in users) {
    document.getElementById("allUsers").innerHTML += `<div class="row text-center">
      <div class="col-2  pt-1 pb-1 ">${users[user].firstname}</div>
      <div class="col-2  pt-1 pb-1 ">${users[user].lastname}</div>
      <div class="col-1  pt-1 pb-1 ">${users[user].mobile}</div>
      <div class="col-2  pt-1 pb-1 ">${users[user].email}</div>
      <div class="col-1  pt-1 pb-1 ">${users[user].category}</div>
      <div class="col-2  pt-1 pb-1 ">${users[user].submitted}</div>
      <div class="col-1  pt-1 pb-1 ">
      <button class="btn btn-warning" data-bs-toggle="modal" onclick="editUserForm('${Object.values(
        users[user]
      )}')" data-bs-target="#staticBackdrop" >Edit</button></div>
      <div class="col-1  pt-1 pb-1 ">
      <button class="btn btn-danger" onclick="deleteUser(${
        users[user].id
      })">Delete</button></div>
        </div>
        `;
  }
}

function editUserForm(param) {
  let user = param.split(",");
  document.getElementById("editId").value = user[0];
  document.getElementById("editfirstname").value = user[1];
  document.getElementById("editlastname").value = user[2];
  document.getElementById("editemail").value = user[3];
  document.getElementById("editmobile").value = user[4];
  document.getElementById("editcategory").value = user[5];
}

async function deleteUser(id) {
  await fetch(`http://localhost:8000/index.php/user/list?id=${id}`, {
    method: "DELETE",
    mode: "cors",
    headers: {
      "Content-Type": "application/json",
    },
  });
  getUsers();
}

async function updateUser() {
  let id = document.getElementById("editId").value;
  let firstname = document.getElementById("editfirstname").value;
  let lastname = document.getElementById("editlastname").value;
  let email = document.getElementById("editemail").value;
  let mobile = document.getElementById("editmobile").value;
  let category = document.getElementById("editcategory").value;
  let user = { 
    id: id,
    firstname: firstname,
    lastname: lastname,
    email: email,
    mobile: mobile,
    category: category,
  }
   
  let response = await fetch(`http://localhost:8000/index.php/user/list`, {
    method: "PUT",
    mode: "cors",
    headers: {
      "Content-Type": "application/json",
    },
    body:JSON.stringify(user)
    
  });
  console.log(await response.json())
  window.location.href="http://127.0.0.1:5500/edit.html";
}


async function insertUser() {
  let firstname = document.getElementById("firstname").value;
  let lastname = document.getElementById("lastname").value;
  let email = document.getElementById("email").value;
  let mobile = document.getElementById("mobile").value;
  let category = document.getElementById("category").value;
  let user = { 
    firstname: firstname,
    lastname: lastname,
    email: email,
    mobile: mobile,
    category: category,
  }
   
  let response = await fetch(`http://localhost:8000/index.php/user/list`, {
    method: "POST",
    mode: "cors",
    headers: {
      "Content-Type": "application/json",
    },
    body:JSON.stringify(user)
    
  });
  console.log(await response.json())
  window.location.href="http://127.0.0.1:5500/submit.html";
}
