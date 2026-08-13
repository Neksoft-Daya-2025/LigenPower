<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Product Warranty Form</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      background: #f5f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      max-width: 900px;
      margin: 50px auto;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .form-label {
      font-weight: 500;
    }
    .btn-submit {
      background-color: #7AB730;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      transition: all 0.3s ease;
    }
    .btn-submit:hover {
      background-color: #5a8e24;
      transform: translateY(-2px);
    }
    .upload-box {
      border: 2px dashed #ccc;
      border-radius: 10px;
      text-align: center;
      padding: 25px;
      background-color: #fafafa;
      transition: 0.3s;
    }
    .upload-box:hover {
      border-color: #7AB730;
      background: #f1fdf0;
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #7AB730;
    }
  </style>
</head>
<body>

<div class="container form-container">
  <div class="card p-4">
      <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-danger text-center"><?= session()->getFlashdata('success') ?></div>
          <?php endif; ?>
    <h4 class="text-center mb-4 fw-bold text-success">Product Warranty Form</h4>
    <form id="myForm" class="needs-validation" enctype="multipart/form-data" novalidate>
      <?= csrf_field() ?>
      <div class="row g-3">
        <div class="col-md-4">
          <label class="form-label">Product Serial Number</label>
          <input type="text" id="serial_num" name="serial_num" class="form-control" placeholder="e.g., SN123456789" required="">
        </div>
        <div class="col-md-4">
          <label class="form-label">Purchase Date</label>
          <input type="date" id="p_date" name="p_date" class="form-control" required>
        </div>
        <div class="col-md-4">
          <label for="textOnlyInput" class="form-label">Bill Number</label>
          <input type="text" id="bill_num" name="bill_num" class="form-control" placeholder="e.g., INV-00123" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Seller Name</label>
          <input type="text" id="seller_name" name="seller_name" class="form-control" placeholder="e.g., Electronics Mart" onkeypress="return isTextOnly(event)" onpaste="return handlePaste(event)" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Customer Name</label>
          <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="e.g., Jane Doe" onkeypress="return isTextOnly(event)" onpaste="return handlePaste(event)" required>
        </div>

        <div class="col-md-6">
          <label class="form-label">Customer Email</label>
          <input type="email" id="customer_email" name="customer_email" class="form-control" placeholder="e.g., warranty@example.com" oninput="validateEmail(this)" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Customer Phone</label>
          <input type="tel" id="customer_phone" name="customer_phone" class="form-control" placeholder="e.g., 9876543210" pattern="[0-9]{10}" maxlength="10" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Pincode</label>
          <input type="tel" id="pincode" name="pincode" class="form-control" placeholder="e.g., 123456" pattern="[0-9]{6}" maxlength="6" required>
        </div>

        <div class="col-12">
          <label class="form-label">Upload Bill Receipt</label>
          <div class="upload-box">
            <input class="form-control" id="imageFile" name="imageFile" type="file" accept=".pdf,.png,.jpg,.jpeg" required>
            <small class="text-muted">Accepted: PDF, PNG, JPG (max 1MB)</small>
          </div>
        </div>

        <div class="col-12 text-center mt-4">
          <button type="button" id="submitBtn" class="btn btn-submit px-5 py-2">Submit</button>
        </div>
      </div>
    </form>
  </div>
</div>
<script type="text/javascript">
 $('#submitBtn').click(function (e) {
    e.preventDefault();
    const form = document.getElementById('myForm');
    const button = this;
    const originalButtonHtml = 'Submit';
    const file = $('#imageFile')[0].files[0];

    form.classList.add('was-validated');
    if (!form.checkValidity()) {
        Swal.fire({ title: 'Missing details', text: 'Please fill all required fields correctly.', icon: 'warning', confirmButtonText: 'OK' });
        return;
    }
    if (!file) {
        Swal.fire({ title: 'Bill receipt required', text: 'Please upload bill receipt PDF, PNG or JPG.', icon: 'warning', confirmButtonText: 'OK' });
        return;
    }
    const allowedTypes = ['application/pdf', 'image/png', 'image/jpeg'];
    const allowedExt = /\.(pdf|png|jpe?g)$/i;
    if (!allowedTypes.includes(file.type) && !allowedExt.test(file.name)) {
        Swal.fire({ title: 'Invalid file', text: 'Only PDF, PNG and JPG files are allowed.', icon: 'error', confirmButtonText: 'OK' });
        return;
    }
    if (file.size > 1024 * 1024) {
        Swal.fire({ title: 'File too large', text: 'Please upload a file up to 1MB only.', icon: 'error', confirmButtonText: 'OK' });
        return;
    }

    button.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...';
    button.disabled = true;

        var reader = new FileReader();

        reader.onload = function (event) {
            // event.target.result contains the Base64 string
            var base64Image = event.target.result.split(',')[1]; // remove "data:image/jpeg;base64,"

            // create data object
            var formData = {
                serial_num: $('#serial_num').val(),
                p_date: $('#p_date').val(),
                bill_num: $('#bill_num').val(),
                seller_name: $('#seller_name').val(),
                customer_name: $('#customer_name').val(),
                customer_email: $('#customer_email').val(),
                customer_phone: $('#customer_phone').val(),
                pincode: $('#pincode').val(),
                image_base64: base64Image // send base64 instead of file
            };

            // send via AJAX
            $.ajax({
                url: '<?= base_url()?>savedata',
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(formData),
                success: function (response) {
                    const check = typeof response === 'string' ? JSON.parse(response) : response;
                    const status = check.status;
                    const message = check.message;
                    if(status == 'error'){
                      Swal.fire({
                        title: 'Error!',
                        text: message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                      }).then((result) => {
                      if (result.isConfirmed) {
                        location.reload();
                      }
                    });
                    }
                    // text: message +' with this '+ formData['serial_num'] + ' Serial Number.',
                    if(status == 'success'){
                      Swal.fire({
                        title: 'Success!',
                        text: message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                      }).then((result) => {
                      if (result.isConfirmed) {
                        location.reload();
                      }
                    });
                    }
                },
                error: function (error) {
                    console.error('Error:', error);
                    Swal.fire({ title: 'Error!', text: 'Warranty submission failed. Please try again.', icon: 'error', confirmButtonText: 'OK' });
                },
                complete: function () {
                    button.innerHTML = originalButtonHtml;
                    button.disabled = false;
                }
            });
        };

        reader.onerror = function () {
            button.innerHTML = originalButtonHtml;
            button.disabled = false;
            Swal.fire({ title: 'File error', text: 'Could not read uploaded receipt. Please try another file.', icon: 'error', confirmButtonText: 'OK' });
        };

        reader.readAsDataURL(file); // convert to base64
});
</script>
<script>
function isTextOnly(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;

  // Allow backspace, delete, and arrow keys (common navigation keys)
  if (charCode === 8 || charCode === 46 || (charCode >= 37 && charCode <= 40)) {
    return true;
  }

  // Disallow numbers (0-9)
  if (charCode >= 48 && charCode <= 57) {
    return false;
  }

  return true; // Allow all other characters (letters, symbols, spaces)
}

function handlePaste(evt) {
  var pastedText = (evt.clipboardData || window.clipboardData).getData('text');
  // Use a regular expression to remove all numeric characters from the pasted text
  var filteredText = pastedText.replace(/[0-9]/g, '');
  
  // Prevent default paste and insert filtered text
  evt.preventDefault();
  document.execCommand('insertText', false, filteredText);
  return false;
}
</script>
<script>
    function validateEmail(input) {
      const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // basic email regex
      if (input.value === "") {
        input.classList.remove("is-valid", "is-invalid");
        return;
      }

      if (emailPattern.test(input.value)) {
        const myButton = document.getElementById('submitBtn');
        myButton.disabled = false;
        input.classList.add("is-valid");
        input.classList.remove("is-invalid");
      } else {
        const myButton = document.getElementById('submitBtn');
        myButton.disabled = true;
        input.classList.add("is-invalid");
        input.classList.remove("is-valid");
      }
    }

  </script>
</body>
</html>
