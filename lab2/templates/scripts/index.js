document.addEventListener("DOMContentLoaded", function () {
  const addToCartButtons = document.querySelectorAll(".add-to-cart");

  addToCartButtons.forEach((button) => {
    button.addEventListener("click", function () {
      const product_id = this.closest(".product-item").dataset.product_id;
      sendDataToServer(product_id);
      showAddedToCartMessage();
    });
  });

  function sendDataToServer(product_id) {
    const data = { product_id: product_id };
    fetch("../server/add_to_cart.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => {
        if (response.ok) {
          console.log("Товар успешно добавлен в корзину");
        } else {
          console.error("Ошибка при добавлении товара в корзину");
        }
      })
      .catch((error) => {
        console.error("Ошибка при отправке запроса:", error);
      });
  }

  function showAddedToCartMessage() {
    const addedToCartMessage = document.getElementById("addedToCartMessage");
    addedToCartMessage.style.display = "block";
    setTimeout(function () {
      addedToCartMessage.style.display = "none";
    }, 3000); // Скрыть сообщение через 3 секунды
  }
});
