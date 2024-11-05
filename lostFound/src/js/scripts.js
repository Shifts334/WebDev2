document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.getAttribute('data-id');
            openModal(itemId);
        });
    });

    function openModal(id) {
        fetch(`get_item.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.querySelector('#modal-title').innerText = data.name;
            document.querySelector('#modal-body').innerHTML = `
                <p>Date: ${data.date_found}</p>
                <p>Location: ${data.location}</p>
                <p>Category: ${data.category}</p>
                <p>Description: ${data.description}</p>
            `;
            document.querySelector('#modal').style.display = 'block';
        });
    }

    document.querySelector('#close-modal').addEventListener('click', function() {
        document.querySelector('#modal').style.display = 'none';
    });
});