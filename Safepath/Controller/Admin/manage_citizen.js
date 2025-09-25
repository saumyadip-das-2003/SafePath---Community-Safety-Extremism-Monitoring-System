// Toggle visibility of the Add Citizen form
        function toggleAddCitizenForm() {
            var form = document.getElementById('add-citizen-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        // View Citizen Function (opens modal with data)
        function viewCitizen(id) {
            // Fetch citizen data from the server using AJAX
            fetch('view_citizen.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    // Populate the modal with citizen data
                    document.getElementById('citizen-id').value = data.id;
                    document.getElementById('view-name').value = data.name;
                    document.getElementById('view-dob').value = data.dob;
                    document.getElementById('view-mobile').value = data.mobile;
                    document.getElementById('view-email').value = data.email;
                    document.getElementById('view-nid').value = data.nid;

                    // Show the modal
                    document.getElementById('view-citizen-modal').style.display = 'block';
                });
        }

        // Close the modal
        function closeModal() {
            document.getElementById('view-citizen-modal').style.display = 'none';
        }

        // Edit Citizen Function
        function editCitizen() {
            document.getElementById('view-name').disabled = false;
            document.getElementById('view-dob').disabled = false;
            document.getElementById('view-mobile').disabled = false;
            document.getElementById('view-nid').disabled = false;
            document.getElementById('save-changes-btn').style.display = 'inline-block';
        }

        // Handle saving changes
        document.getElementById('view-citizen-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            fetch('update_citizen.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Citizen updated successfully!');
                    closeModal();
                    location.reload();
                } else {
                    alert('Error updating citizen.');
                }
            });
        });
		
		
		