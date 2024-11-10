let cart = JSON.parse(localStorage.getItem('cart')) || [];
let cartCount = document.getElementById("cart-count");
let cartItems = document.getElementById("cart-items");
let totalPrice = document.getElementById("total-price");
let cartModal = document.getElementById("cart-modal");
let closeBtn = document.querySelector(".close");
let checkoutButton = document.getElementById("checkoutButton");

// Update cart display on page load
updateCart();

// Add event listeners
document.getElementById("cart-link").addEventListener("click", openCartModal);
closeBtn.addEventListener("click", closeCartModal);

function addToCart(productName, price) {
    // Check if the product already exists in the cart
    const existingProduct = cart.find(item => item.name === productName);
    
    if (existingProduct) {
        // If it exists, increment the quantity
        existingProduct.quantity += 1;
    } else {
        // Otherwise, add it to the cart with quantity 1
        cart.push({ name: productName, price: price, quantity: 1 });
    }

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
            li.textContent = `${item.name} - €${item.price.toFixed(2)} x ${item.quantity}`;

            let deleteButton = document.createElement("button");
            deleteButton.textContent = "Verwijder";
            deleteButton.onclick = function() {
                removeFromCart(index);
            };

            li.appendChild(deleteButton);
            cartItems.appendChild(li);
            total += item.price * item.quantity; // Calculate total price
        });
    }

    totalPrice.textContent = total.toFixed(2);
}

function removeFromCart(index) {
    cart.splice(index, 1); // Remove item from cart
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

// Checkout functionality
if (checkoutButton) {
    checkoutButton.onclick = function() {
        if (cart.length === 0) {
            alert("Je winkelwagentje is leeg! Voeg items toe voordat je afrekent.");
            return;
        }
        alert("Afrekenen is nog niet geïmplementeerd. Dit is een voorbeeld.");
        // Here you could redirect to a checkout page or process payment
    };
}