<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cart_item']) && isset($_POST['quantity'])) {
    $id_cart_item = $_POST['id_cart_item'];
    $quantity = $_POST['quantity'];

    if ($quantity < 1) {
        $quantity = 1;
    }

    // Update quantity and total price
    $queryUpdate = "UPDATE cart_items SET quantity = '$quantity', total_price = price * '$quantity', updated_at = CURRENT_TIMESTAMP WHERE id_cart_item = '$id_cart_item'";
    $resultUpdate = mysqli_query($conn, $queryUpdate);

    if ($resultUpdate) {
        echo "Cart updated successfully";
    } else {
        echo "Failed to update cart";
    }
}
?>



<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id_cart_item']) && isset($_POST['product_name'])) {
    $id_product = $_POST['id_cart_item'];
    $product_name = $_POST['product_name'];

    // Fetch the product price from the database
    $queryProduct = "SELECT price FROM products WHERE id_product = '$id_product'";
    $resultProduct = mysqli_query($conn, $queryProduct);
    $product = mysqli_fetch_assoc($resultProduct);
    $price = $product['price'];

    // Check if the product is already in the cart
    $queryCart = "SELECT * FROM cart_items WHERE id_product = '$id_product'";
    $resultCart = mysqli_query($conn, $queryCart);

    if (mysqli_num_rows($resultCart) > 0) {
        // If the product is already in the cart, update the quantity and total price
        $cartItem = mysqli_fetch_assoc($resultCart);
        $newQuantity = $cartItem['quantity'] + 1;
        $newTotalPrice = $newQuantity * $price;

        $queryUpdate = "UPDATE cart_items SET quantity = '$newQuantity', total_price = '$newTotalPrice', updated_at = CURRENT_TIMESTAMP WHERE id_cart_item = '{$cartItem['id_cart_item']}'";
        $resultUpdate = mysqli_query($conn, $queryUpdate);

        if ($resultUpdate) {
            echo "Cart updated successfully";
        } else {
            echo "Failed to update cart";
        }
    } else {
        // If the product is not in the cart, insert a new row
        $quantity = 1;
        $total_price = $quantity * $price;

        $queryInsert = "INSERT INTO cart_items (id_product, product_name, quantity, price, total_price) VALUES ('$id_product', '$product_name', '$quantity', '$price', '$total_price')";
        $resultInsert = mysqli_query($conn, $queryInsert);

        if ($resultInsert) {
            echo "Product added to cart successfully";
        } else {
            echo "Failed to add product to cart";
        }
    }
}
?>
