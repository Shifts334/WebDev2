document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    const tableBody = document.querySelector('#contact-table tbody');
    let editIndex = -1;
    let contacts = [];

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        const lastName = document.getElementById('last-name').value.trim();
        const firstName = document.getElementById('first-name').value.trim();
        const email = document.getElementById('email').value.trim();
        const contactNumber = document.getElementById('contact-number').value.trim();
        const errorMessage = document.getElementById('error-message');
        const contactId = document.getElementById('contact-id').value;

        // Validate email format and uniqueness
        if (!validateEmail(email)) {
            errorMessage.textContent = 'Invalid email format.';
            return;
        }

        if (contacts.some(contact => contact.email === email && editIndex === -1)) {
            errorMessage.textContent = 'Duplicate email address.';
            return;
        }

        errorMessage.textContent = '';

        if (contactId === '') {
            // Add contact
            $.ajax({
                type: 'POST',
                url: '../src/php/add.php',
                data: { lastName, firstName, email, contactNumber },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 200) {
                        contacts.push(res.data);
                        renderContacts();
                    } else {
                        alert('Failed to add contact.');
                    }
                }
            });
        } else {
            // Edit contact
            $.ajax({
                type: 'POST',
                url: '../src/php/edit.php',
                data: { id: contactId, lastName, firstName, email, contactNumber },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 200) {
                        contacts[editIndex] = res.data;
                        renderContacts();
                    } else {
                        alert('Failed to update contact.');
                    }
                }
            });
        }

        form.reset();
        document.getElementById('contact-id').value = '';
        editIndex = -1;
    });

    function getData() {
        $.ajax({
            type: 'GET',
            url: '../src/php/read.php',
            data: "",
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 200) {
                    contacts = res.data;
                    renderContacts();
                }
            }
        });
    }

    function renderContacts() {
        tableBody.innerHTML = '';
        contacts.forEach((contact, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${contact.lastName}</td>
                <td>${contact.firstName}</td>
                <td>${contact.email}</td>
                <td>${contact.contactNumber}</td>
                <td class="actions">
                    <button class="edit-button" onclick="editContact(${index})">Edit</button>
                    <button onclick="deleteContact(${index}, ${contact.id})">Delete</button>
                </td>
            `;
            tableBody.appendChild(row);
        });
    }

    window.editContact = function(index) {
        const contact = contacts[index];
        document.getElementById('contact-id').value = contact.id;
        document.getElementById('last-name').value = contact.lastName;
        document.getElementById('first-name').value = contact.firstName;
        document.getElementById('email').value = contact.email;
        document.getElementById('contact-number').value = contact.contactNumber;
        editIndex = index;
    };

    window.deleteContact = function(index, id) {
        $.ajax({
            type: 'POST',
            url: '../src/php/delete.php',
            data: { id },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 200) {
                    contacts.splice(index, 1);
                    renderContacts();
                } else {
                    alert('Failed to delete contact.');
                }
            }
        });
    };

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    getData();
});
