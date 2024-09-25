function searchItems() {
    const query = document.getElementById("search").value.toLowerCase();
    const items = document.querySelectorAll('.item-card');
    items.forEach(item => {
        const itemName = item.querySelector('h3').textContent.toLowerCase();
        if (itemName.includes(query)) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function filterByCategory() {
    const category = document.getElementById("categoryFilter").value;
    const items = document.querySelectorAll('.item-card');
    items.forEach(item => {
        const itemCategory = item.querySelector('.item-details p:nth-child(4)').textContent.split(": ")[1];
        if (category === "" || itemCategory === category) {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    });
}

function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

function openUpdateModal(id) {
    fetch(`get_item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('updateId').value = data.id;
            document.getElementById('updateDateTime').value = data.date_time;
            document.getElementById('updateLocationFound').value = data.location_found;
            document.getElementById('updateCategory').value = data.category;
            document.getElementById('currentImage').value = data.imageLocation;
            openModal('updateModal');
        });
}

function openDeleteModal(id) {
    document.getElementById('deleteId').value = id;
    openModal('deleteModal');
}

document.getElementById('createForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('create.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(data => {
          alert(data);
          closeModal('createModal');
          location.reload();
      });
});

document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('update.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(data => {
          alert(data);
          closeModal('updateModal');
          location.reload();
      });
});

document.getElementById('deleteForm').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('delete.php', {
        method: 'POST',
        body: formData
    }).then(response => response.text())
      .then(data => {
          alert(data);
          closeModal('deleteModal');
          location.reload();
      });
});