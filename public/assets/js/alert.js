document.addEventListener("DOMContentLoaded", function () {
    // Ambil pesan dari meta tag (nanti dikirim dari controller)
    const successMessage = document.querySelector(
        'meta[name="success-message"]'
    )?.content;
    const errorMessage = document.querySelector(
        'meta[name="error-message"]'
    )?.content;

    if (successMessage) {
        Swal.fire({
            icon: "success",
            title: "Berhasil!",
            text: successMessage,
            showConfirmButton: false,
            timer: 2000,
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: errorMessage,
            showConfirmButton: true,
        });
    }
});
