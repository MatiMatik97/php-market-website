<?php

class storeManager
{
    function removeFromStoreForm($id) {
        echo "<form class='form' method='post'>
                <input type='text' name='id' value='$id'>
                <button class='fas remove-icon fa-trash-alt' type='submit' name='submit' value='removeFromStore'></button>
            </form>";
    }

    function removeFromStore($db) {
        $args = [
            'id' => FILTER_VALIDATE_INT
        ];

        $data = filter_input_array(INPUT_POST, $args);
        $productId = $data["id"];

        $sql = "DELETE FROM `market` where id=$productId;";
        $db->delete($sql);

        $_SESSION["removed-from-store"] = true;
    }
}
