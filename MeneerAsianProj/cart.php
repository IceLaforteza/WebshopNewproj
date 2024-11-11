<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Winkelwagentje</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>Winkelwagentje</h1>
    <nav>
        <a href="index.php">Home</a>
    </nav>
</header>

<section class="cart">
    <h2>Je winkelwagentje</h2>
    <ul id="cartItems"></ul>
    <p>Totaal: €<span id="totalPrice">0.00</span></p>
    <button id="checkoutButton" class="checkout-button">Afrekenen</button>
</section>

<script>
    // Fetch cart from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartItems = document.getElementById("cartItems");
    let totalPrice = document.getElementById("totalPrice");

    function updateCart() {
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
        localStorage.setItem('cart', JSON.stringify(cart)); // Update localStorage
        updateCart(); // Refresh the cart display
    }

    // Initial call to display the cart
    updateCart();

    // Checkout functionality
    document.getElementById("checkoutButton").onclick = function() {
        if (cart.length === 0) {
            alert("Je winkelwagentje is leeg! Voeg items toe voordat je afrekent.");
            return;
        }
        alert("Afrekenen is nog niet geïmplementeerd. Dit is een voorbeeld.");
    };
</script>

</body>
</html>