<?php

class accountManager
{
    function showAccount($db)
    {
        $id = $_SESSION["id"];

        $sql = "SELECT userName, cash, `date`, fullName  FROM `users` where `id`=$id;";
        $result = $db->select($sql);
        $row = $result->fetch_assoc();
        $userName = $row["userName"];
        $fullName = $row["fullName"];
        $cash = $row["cash"];
        $date = $row["date"];

        $sql = "SELECT COUNT(*) as `count` FROM market WHERE `user_id`=$id;";
        $result = $db->select($sql);
        $row = $result->fetch_assoc();
        $countMarket = $row["count"];

        $sql = "SELECT COUNT(*) as `count` FROM cart WHERE `buyer_id`=$id;";
        $result = $db->select($sql);
        $row = $result->fetch_assoc();
        $countCart = $row["count"];

        echo "<p class='acc-text'>
        Nazwa użytkownika: $userName<br/>
        Pełna nazwa: $fullName<br/>
        Dostępne środki: $cash";
        echo "zł<br/>
        Data założenia: $date<br/>
        Wystawione produkty: $countMarket<br/>
        Produkty w koszyku: $countCart</p>";
    }

    function addCashForm()
    {
        echo '
            <form class="form" method="post">
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Dodaj środki do konta:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-money-bill-wave"></i></span>
                            </div>
                            <input type="number" min="0" step="0.01" class="form-control cash" name="cash" placeholder="Kwota[zł]">
                            <div class="invalid-feedback">
                                Nieprawidłowa kwota.
                            </div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Dodaj">
                <p class="valid-add"></p>
            </form>';
    }

    function addCash($db)
    {
        $args = [
            'cash' => FILTER_VALIDATE_FLOAT
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
            $id = $_SESSION["id"];
            $sql = "SELECT cash FROM `users` where `id`=$id;";
            $result = $db->select($sql);
            $row = $result->fetch_assoc();
            $cash = $row["cash"];
            $cashForm = $data["cash"];
            $cashToAdd = $cash + $cashForm;

            $sql = "UPDATE `users` SET `cash`='$cashToAdd' WHERE `users`.`id`=$id;";
            $db->update($sql);
        } else {
            if (is_array($errors)) {
                $_SESSION["form-invalid"] = $errors;
            }
        }

        return $sql;
    }
}
