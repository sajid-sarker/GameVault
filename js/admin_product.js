// Function for using modal/pop-up
function openUpdateModal(id, name, price, image) {
  // Set product details in the modal
  document.getElementById('update_p_id').value = id;
  document.getElementById('update_name').value = name;
  document.getElementById('update_price').value = price;
  document.getElementById('update_old_image').value = image;
  document.getElementById('current_product_image').src = './images/disc/' + image;

  // Show the modal
  var updateModal = new bootstrap.Modal(document.getElementById('updateProductModal'), {});
  updateModal.show();
}
