<?php

class cartManager
{
    function removeFromCartForm($id)
    {
        echo "<form class='form' method='post'>
                <input type='text' name='id' value='$id'>
                <button class='fas remove-icon fa-trash-alt' type='submit' name='submit' value='removeFromCart'></button>
            </form>";
    }

    function removeFromCart($db)
    {
        $args = [
            'id' => FILTER_VALIDATE_INT
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $productId = $data["id"];

        $sql = "SELECT * FROM `cart` where id=$productId;";
        $result = $db->select($sql);
        $row = $result->fetch_assoc();
        $productName = $row["productName"];
        $cost = $row["cost"];
        $quantity = $row["quantity"];
        $seller_id = $row["seller_id"];
        $date = new DateTime();
        $date = $date->format("Y-m-d H:i:s");

        $sql = "INSERT INTO `market` VALUES(NULL, '$productName', '$cost', '$quantity', '$seller_id', '$date');";
        $db->insert($sql);

        $sql = "DELETE FROM `cart` where id=$productId;";
        $db->delete($sql);

        $_SESSION["removed-from-cart"] = true;
    }

    function payForm($totalToPay)
    {
        echo "<form class='form-to-pay' method='post'>
                <input type='text' name='totalToPay' value='$totalToPay'>
                <p>Do zapłaty: $totalToPay";
        echo "zł</p><input type='submit' name='submit' class='btn btn-success' value='Zapłać'>
            </form>";
    }

    function pay($db)
    {
        $args = [
            'totalToPay' => FILTER_VALIDATE_FLOAT
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $totalToPay = $data["totalToPay"];

        $id = $_SESSION["id"];

        $sql = "SELECT cash FROM `users` where id=$id;";

        $result = $db->select($sql);
        $row = $result->fetch_assoc();
        $cash = $row["cash"];

        if($cash >= $totalToPay) {
            $cashDiff = $cash - $totalToPay;
            $sql = "UPDATE `users` SET `cash`='$cashDiff' WHERE `users`.`id`=$id;";
            $db->update($sql);

            $sql = "DELETE FROM `cart` where `buyer_id`=$id;";
            $db->delete($sql);
            $_SESSION["valid-pay"] = true;
        } else {
            $_SESSION["invalid-pay"] = true;
        }
    }
}
