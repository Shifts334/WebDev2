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