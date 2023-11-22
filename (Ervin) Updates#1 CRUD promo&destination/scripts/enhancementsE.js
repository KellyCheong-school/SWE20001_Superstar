// Delete
function deletePromotion(promotionId) {
    if (confirm("Are you sure you want to delete this promotion?")) {
        // Send an AJAX request to delete the promotion
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_promotion.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response, if needed
                if (xhr.responseText === 'success') {
                    // Remove the row from the table (optional)
                    var rowToDelete = document.getElementById('promotion' + promotionId);
                    if (rowToDelete) {
                        rowToDelete.remove();
                    }

                    window.location.href = 'create_promotions.php';
                }
            }
        };
        xhr.send('promotionId=' + promotionId);
    }
}

function deleteDestination(destinationId) {
    if (confirm("Are you sure you want to delete this destination?")) {
        // Send an AJAX request to delete the destination
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_destination.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Handle the response, if needed
                if (xhr.responseText === 'success') {
                    // Remove the row from the table (optional)
                    var rowToDelete = document.getElementById('destination' + destinationId);
                    if (rowToDelete) {
                        rowToDelete.remove();
                    }

                    window.location.href = 'create_destination.php';
                }
            }
        };
        xhr.send('destinationId=' + destinationId);
    }
}


// Edit
function editPromotion(promotionId) {
    const headerCell = document.querySelector(`[data-field='promotionheader'][data-promotion-id='${promotionId}']`);
    const descCell = document.querySelector(`[data-field='promotiondesc'][data-promotion-id='${promotionId}']`);
    const editImageBtn = document.querySelector(`.edit-image-button[data-promotion-id='${promotionId}']`);
    const saveButton = document.querySelector(`.save-button[data-promotion-id='${promotionId}']`);

    // Enable content editing for header and description
    headerCell.contentEditable = true;
    descCell.contentEditable = true;

    // Show the "Save" button for header and description
    saveButton.style.display = 'block';
    editImageBtn.style.display = 'block';
    editImageBtn.setAttribute('data-promotion-id', promotionId);
    editImageBtn.onclick = () => editImage(promotionId); // Call editImage function when clicked

    const imageInput = document.createElement('input');
    imageInput.type = 'file';
    imageInput.id = 'imageFile_' + promotionId;
    imageInput.style.display = 'none'; // Initially hide the file input
}

function editDestination(destinationId) {
    const nameCell = document.querySelector(`[data-field='destinationname'][data-destination-id='${destinationId}']`);
    const descCell = document.querySelector(`[data-field='destinationdesc'][data-destination-id='${destinationId}']`);
    const priceCell = document.querySelector(`[data-field='destinationprice'][data-destination-id='${destinationId}']`);
    const editImageBtn = document.querySelector(`.edit-image-button[data-destination-id='${destinationId}']`);
    const saveButton = document.querySelector(`.save-button[data-destination-id='${destinationId}']`);

    // Enable content editing for header and description
    nameCell.contentEditable = true;
    descCell.contentEditable = true;
    priceCell.contentEditable = true;

    // Show the "Save" button for header and description
    saveButton.style.display = 'block';
    editImageBtn.style.display = 'block';
    editImageBtn.setAttribute('data-destination-id', destinationId);
    editImageBtn.onclick = () => editImage2(destinationId); // Call editImage function when clicked

    const imageInput = document.createElement('input');
    imageInput.type = 'file';
    imageInput.id = 'imageFile_' + destinationId;
    imageInput.style.display = 'none'; // Initially hide the file input
}

// Save
function savePromotion(promotionId) {
    const headerCell = document.querySelector(`[data-field='promotionheader'][data-promotion-id='${promotionId}']`);
    const descCell = document.querySelector(`[data-field='promotiondesc'][data-promotion-id='${promotionId}']`);
    
    const newHeader = headerCell.innerText;
    const newDesc = descCell.innerText;

    // Create a request body with the data to be sent to the server
    const data = new URLSearchParams();
    data.append('promotionId', promotionId);
    data.append('newHeader', newHeader);
    data.append('newDesc', newDesc);

    // Send an AJAX request using the fetch API
    fetch('update_promotion.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
    .then(response => response.text())
    .then(result => {
        // Handle the response from the server (e.g., display a success message)
        console.log(result);
        window.location.reload();
    })
    .catch(error => {
        // Handle errors, e.g., display an error message
        console.error(error);
    });
    
    // After successfully saving, disable content editing and hide the "Save" button
    headerCell.contentEditable = false;
    descCell.contentEditable = false;
    const saveButton = document.querySelector(`.save-button[data-promotion-id='${promotionId}']`);
    saveButton.style.display = 'none';
    const editImageBtn = document.querySelector(`.edit-image-button[data-promotion-id='${promotionId}']`);
    editImageBtn.style.display = 'none';
}


function saveDestination(destinationId) {
    const nameCell = document.querySelector(`[data-field='destinationname'][data-destination-id='${destinationId}']`);
    const descCell = document.querySelector(`[data-field='destinationdesc'][data-destination-id='${destinationId}']`);
    const priceCell = document.querySelector(`[data-field='destinationprice'][data-destination-id='${destinationId}']`);
    
    const newName = nameCell.innerText;
    const newDesc = descCell.innerText;
    const newPrice = priceCell.innerText;

    // Create a request body with the data to be sent to the server
    const data = new URLSearchParams();
    data.append('destinationId', destinationId);
    data.append('newName', newName);
    data.append('newDesc', newDesc);
    data.append('newPrice', newPrice);

    // Send an AJAX request using the fetch API
    fetch('update_destination.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: data,
    })
    .then(response => response.text())
    .then(result => {
        // Handle the response from the server (e.g., display a success message)
        console.log(result);
        window.location.reload();
    })
    .catch(error => {
        // Handle errors, e.g., display an error message
        console.error(error);
    });
    
    // After successfully saving, disable content editing and hide the "Save" button
    nameCell.contentEditable = false;
    descCell.contentEditable = false;
    priceCell.contentEditable = false;
    const saveButton = document.querySelector(`.save-button[data-destination-id='${destinationId}']`);
    saveButton.style.display = 'none';
    const editImageBtn = document.querySelector(`.edit-image-button[data-destination-id='${destinationId}']`);
    editImageBtn.style.display = 'none';
}

// Edit
function editImage(promotionId) {
    document.querySelectorAll('.edit-image-button').forEach(button => {
        button.addEventListener('click', function () {
            const promotionId = this.getAttribute('data-promotion-id');
            // Trigger the file input for image selection
            const imageInput = document.querySelector(`#imageFile_${promotionId}`);
            imageInput.style.display = 'block'; // Display the file input
            imageInput.addEventListener('change', function () {
                // Handle the image file selection (e.g., upload the new image)
                const newImage = this.files[0];
                if (newImage) {
                    // Send the new image to the server for processing
                    updateImage(promotionId, newImage);
                }
    });
    });
    });
}

function editImage2(destinationId) {
    document.querySelectorAll('.edit-image-button').forEach(button => {
        button.addEventListener('click', function () {
            const destinationId = this.getAttribute('data-destination-id');
            // Trigger the file input for image selection
            const imageInput = document.querySelector(`#imageFile_${destinationId}`);
            imageInput.style.display = 'block'; // Display the file input
            imageInput.addEventListener('change', function () {
                // Handle the image file selection (e.g., upload the new image)
                const newImage = this.files[0];
                if (newImage) {
                    // Send the new image to the server for processing
                    updateImage2(destinationId, newImage);
                }
    });
    });
    });
}

//Update
function updateImage(promotionId, newImage) {
    const formData = new FormData();
    formData.append('promotionId', promotionId);
    formData.append('newImage', newImage);

    // Send the new image to the server using a fetch request or AJAX
    fetch('update_promotion.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(result => {
        // Handle the server's response (e.g., display a success message)
        console.log(result);
    })
    .catch(error => {
        // Handle errors (e.g., display an error message)
        console.error(error);
    });
}


function updateImage2(destinationId, newImage) {
    const formData = new FormData();
    formData.append('destinationId', destinationId);
    formData.append('newImage', newImage);

    // Send the new image to the server using a fetch request or AJAX
    fetch('update_destination.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.text())
    .then(result => {
        // Handle the server's response (e.g., display a success message)
        console.log(result);
    })
    .catch(error => {
        // Handle errors (e.g., display an error message)
        console.error(error);
    });
}