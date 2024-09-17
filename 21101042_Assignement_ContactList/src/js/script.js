$(document).ready(function() {
    function getData() {
        $.ajax({
            url: '../src/php/read.php',
            type: 'GET',
            success: function(response) {
                let data = JSON.parse(response);
                if (data.status === 200) {
                    let contacts = data.data;
                    let tableBody = $('#contact-table tbody');
                    tableBody.empty();
                    contacts.forEach(contact => {
                        tableBody.append(`
                            <tr>
                                <td>${contact.lastName}</td>
                                <td>${contact.firstName}</td>
                                <td>${contact.email}</td>
                                <td>${contact.number}</td>
                                <td>
                                    <button onclick="editContact(${contact.id})">Edit</button>
                                    <button onclick="deleteContact(${contact.id})">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                } else {
                    console.error("Error fetching data: ", data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching data: ", error);
            }
        });
    }

    $('#contact-form').submit(function(event) {
        event.preventDefault();
        if (!validateForm()) {
            return;
        }
        let contactId = $('#contact-id').val();
        let formData = {
            fname: $('#first-name').val(),
            lname: $('#last-name').val(),
            emailAdd: $('#email').val(),
            contactNum: $('#contact-number').val()
        };
        let url = contactId ? '../src/php/edit.php' : '../src/php/add.php';
        if (contactId) {
            formData.id = contactId;
            formData.curEmail = $('#email').val(); // Assuming current email is the same as the new email
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#contact-form')[0].reset();
                $('#contact-id').val('');
                getData();
            },
            error: function(xhr, status, error) {
                console.error("Error submitting form: ", error);
            }
        });
    });

    function validateForm() {
        let isValid = true;
        let errorMessage = '';

        if ($('#last-name').val().trim() === '') {
            isValid = false;
            errorMessage += 'Last Name is required.\n';
        }
        if ($('#first-name').val().trim() === '') {
            isValid = false;
            errorMessage += 'First Name is required.\n';
        }
        if ($('#email').val().trim() === '') {
            isValid = false;
            errorMessage += 'Email Address is required.\n';
        } else if (!validateEmail($('#email').val().trim())) {
            isValid = false;
            errorMessage += 'Invalid Email Address.\n';
        }
        if ($('#contact-number').val().trim() === '') {
            isValid = false;
            errorMessage += 'Contact Number is required.\n';
        } else if (!/^\d{10,15}$/.test($('#contact-number').val().trim())) {
            isValid = false;
            errorMessage += 'Contact Number must be between 10 and 15 digits.\n';
        }

        if (!isValid) {
            $('#error-message').text(errorMessage);
        } else {
            $('#error-message').text('');
        }

        return isValid;
    }

    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    window.editContact = function(id) {
        $.ajax({
            url: '../src/php/read.php',
            type: 'GET',
            data: { id: id },
            success: function(response) {
                let contact = JSON.parse(response).data;
                if (contact.length > 0) {
                    contact = contact[0];
                    $('#contact-id').val(contact.id);
                    $('#last-name').val(contact.lastName);
                    $('#first-name').val(contact.firstName);
                    $('#email').val(contact.email);
                    $('#contact-number').val(contact.number);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching contact: ", error);
            }
        });
    };

    window.deleteContact = function(id) {
        $.ajax({
            url: '../src/php/delete.php',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                getData();
            },
            error: function(xhr, status, error) {
                console.error("Error deleting contact: ", error);
            }
        });
    };

    getData();
});