<?php

class marketManager
{
    function addToMarketForm()
    {
        echo '<form class="form" method="post">
                <div class="form-row">
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                     <span class="form-text">Nazwa produktu(4+ znaków):</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-file-signature"></i></span>
                            </div>
                            <input type="text" class="form-control productName" name="productName" placeholder="Nazwa produktu" title="Minimum 4 znaki">
                            <div class="invalid-feedback">
                                Nieprawidłowa nazwa produktu.
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Cena:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span>
                            </div>
                            <input type="number" min="0" step="0.01" class="form-control cost" name="cost" placeholder="Cena[zł/szt.]">
                            <div class="invalid-feedback">
                                Nieprawidłowa cena.
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Ilość:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-balance-scale"></i></span>
                            </div>
                            <input type="number" min="0" class="form-control quantity" name="quantity" placeholder="Ilość">
                            <div class="invalid-feedback">
                                Nieprawidłowa ilość.
                            </div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Wystaw">
                <p class="valid-add"></p>
            </form>';
    }

    function addToMarket($db)
    {
        $args = [
            'productName' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                //4-20 znaków
                'options' => ['regexp' => '/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._ąćęłńóśżźĄĆĘŁŃÓŚŻŹ ]+(?<![_.])$/']
            ],
            'cost' => FILTER_VALIDATE_FLOAT,
            'quantity' => FILTER_VALIDATE_INT
        ];

        $data = filter_input_array(INPUT_POST, $args);

        $errors = array();
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                if ($val == "" or $val == NULL) {
                    array_push($errors, $key);
                }
            }
        }

        $sql = "";

        if (count($errors) === 0) {
            $productName = $data["productName"];
            $cost = $data["cost"];
            $quantity = $data["quantity"];
            $id = $_SESSION["id"];
            $date = new DateTime();
            $date = $date->format("Y-m-d H:i:s");

            $sql = "INSERT INTO market VALUES (NULL, '$productName', '$cost', '$quantity', '$id', '$date');";
        } else {
            if (is_array($errors)) {
                $_SESSION["form-invalid"] = $errors;
            }
        }

        return $sql;
    }

    function addToCartForm($max, $id)
    {
        echo "<form class='form' method='post'>
                <div class='form-row'>
                    <div class='col-auto ml-auto mr-auto w-100 mb-3'>
                        <div class='input-group'>
                            <input type='number' max='$max' min='1' class='form-control' name='quantity' placeholder='Ilość'>
                            <input type='text' name='id' value='$id'>
                            <div class='invalid-feedback'>
                                Nieprawidłowa nazwa produktu.
                            </div>
                        </div>
                    </div>
                </div>
                <button class='fas add-icon fa-plus-circle' type='submit' name='submit' value='addToCart'></button>
            </form>";
    }

    function addToCart($db)
    {
        $args = [
            'id' => FILTER_VALIDATE_INT,
            'quantity' => FILTER_VALIDATE_INT
        ];

        $data = filter_input_array(INPUT_POST, $args);

        $id = $data["id"];
        $quantity = $data["quantity"];

        if ($quantity != "") {
            $sql = "SELECT quantity, cost, productName, `user_id` FROM market WHERE id=$id";
            $result = $db->select($sql);
            $row = $result->fetch_assoc();
            $maxQuantity = $row["quantity"];
            $cost = $row["cost"];
            $productName = $row["productName"];
            $seller_id = $row["user_id"];
            $date = new DateTime();
            $date = $date->format("Y-m-d H:i:s");
            $total = $cost * $quantity;
            $buyer_id = $_SESSION["id"];

            $sql = "INSERT INTO `cart` VALUES (NULL, '$productName', '$cost', '$quantity', '$total', '$seller_id', '$buyer_id', '$date');";
            $db->insert($sql);

            $diffQuantity = $maxQuantity - $quantity;
            if ($diffQuantity == 0) {
                $sql = "DELETE FROM market WHERE id=$id";
                $db->delete($sql);
            } else {
                $sql = "UPDATE `market` SET quantity='$diffQuantity' WHERE id=$id";
                $db->update($sql);
            }

            $_SESSION["valid-add-to-cart"] = true;
        } else {
            $_SESSION["invalid-add-to-cart"] = true;
        }
    }
}
