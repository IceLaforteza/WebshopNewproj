let cart = JSON.parse(localStorage.getItem('cart')) || [];
let cartCount = document.getElementById("cart-count");
let cartItems = document.getElementById("cart-items");
let totalPrice = document.getElementById("total-price");
let cartModal = document.getElementById("cart-modal");
let closeBtn = document.querySelector(".close");
let checkoutButton = document.getElementById("checkoutButton");

document.getElementById("cart-link").addEventListener("click", openCartModal);
closeBtn.addEventListener("click", closeCartModal);

function addToCart(productName, price) {
    cart.push({ name: productName, price: price });
    updateLocalStorage();
    updateCart();
}

function updateLocalStorage() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCart() {
    cartCount.textContent = cart.length;
    cartItems.innerHTML = '';
    let total = 0;

    if (cart.length === 0) {
        cartItems.innerHTML = '<li>Je winkelwagentje is leeg.</li>';
    } else {
        cart.forEach((item, index) => {
            let li = document.createElement("li");
            li.textContent = item.name + " - €" + item.price.toFixed(2);

            let deleteButton = document.createElement("button");
            deleteButton.textContent = "Verwijder";
            deleteButton.onclick = function() {
                removeFromCart(index);
            };

            li.appendChild(deleteButton);
            cartItems.appendChild(li);
            total += item.price;
        });
    }

    totalPrice.textContent = total.toFixed(2);
}

function removeFromCart(index) {
    cart.splice(index, 1);
    updateLocalStorage();
    updateCart();
}

function openCartModal() {
    cartModal.style.display = "block";
    updateCart();
}

function closeCartModal() {
    cartModal.style.display = "none";
}

if(checkoutButton) {
    checkoutButton.onclick = function() {
        if (cart.length === 0) {
            alert("Je winkelwagentje is leeg! Voeg items toe voordat je afrekent.");
            return;
        }
        alert("Afrekenen is nog niet geïmplementeerd. Dit is een voorbeeld.");

    };
}

updateCart();