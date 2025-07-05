// navbar dropdown
document.addEventListener("DOMContentLoaded", () => {
  const toggler = document.querySelector('.navbar-toggler');
  const dropdownMenu = document.querySelector('.dropdown-menu');
  const closeButton = document.querySelector('.close-button');

  // Membuka menu
  toggler.addEventListener('click', () => {
    dropdownMenu.classList.add('show');
  });

  // Menutup menu
  closeButton.addEventListener('click', () => {
    dropdownMenu.classList.remove('show');
  });
});

  // JavaScript untuk tombol WhatsApp
  function whatsappButton(productName, productImageUrl) {
    const namaProduk = "<?php echo $produk['nama']; ?>";
    const fotoProduk = "<?php echo $produk['foto']; ?>";
    const whatsappNumber = "62895606185527";
    const message = `HALO!! Saya ingin membeli produk: *${productName}*.\nlink produk:\n${productImageUrl}`;
    const url = `https://wa.me/${whatsappNumber}?text=${encodeURIComponent(message)}`;
    window.open(url, '_blank');
};

// Checkout 
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('checkout-form');
  const paymentButton = document.getElementById('payment-btn');
  const cancelButton = document.getElementById('cancel-btn');

  // Enable payment button only if form is valid
  form.addEventListener('input', () => {
    paymentButton.disabled = !form.checkValidity();
  });

  // Redirect to payment gateway when payment button is clicked
  paymentButton.addEventListener('click', () => {
    alert('Mengalihkan ke Payment Gateway...');
    window.location.href = 'https://www.midtrans.com';
  });

  // Cancel button action
  cancelButton.addEventListener('click', () => {
    if (confirm('Anda yakin ingin membatalkan checkout?')) {
      window.location.href = '/';
    }
  });
});

