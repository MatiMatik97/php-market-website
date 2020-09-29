<?php

class UserManager
{
    function loginForm()
    {
        echo    '<form class="form" method="post">
                    <div class="form-group">
                        <span class="form-text">Nazwa użytkownika:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user-tag"></i></span>
                            </div>
                            <input class="form-control" placeholder="Nazwa użytkownika" type="text" name="userName">
                        </div>
                    </div>
                    <div class="form-group">
                        <span class="form-text">Hasło:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i></span>
                            </div>
                            <input class="form-control" placeholder="Hasło" type="password" name="passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="submit" class="btn btn-primary btn-block" value="Zaloguj">
                    </div>
                    <p class="invalid-login"></p>
                    <p class="text-center"><a href="Registration.php" class="btn text">Nie masz konta? Zarejestruj się!</a></p>
                </form>';
    }

    function login($db)
    {
        $args = [
            'userName' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'passwd' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
        ];

        $data = filter_input_array(INPUT_POST, $args);

        $userName = $data["userName"];
        $passwd = $data["passwd"];
        $userId = $db->selectUser($userName, $passwd, "users");

        return $userId;
    }

    function regForm()
    {
        echo '<form class="form" method="post">
                <div class="form-row">
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Nazwa użytkownika(4-20 znaków):</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user-tag"></i></span>
                            </div>
                            <input type="text" class="form-control userName" name="userName" placeholder="Nazwa użytkownika" title="4-20 znaków">
                            <div class="invalid-feedback userName-feedback">
                                Nieprawidłowa nazwa użytkownika.
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Pełna nazwa(3+ znaków):</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control fullName" name="fullName" placeholder="Pełna nazwa" title="Maximum 3 znaki">
                            <div class="invalid-feedback">
                                Nieprawidłowa pełna nazwa.
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Adres e-mail:</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="text" class="form-control email" name="email" placeholder="E-mail">
                            <div class="invalid-feedback email-feedback">
                                Nieprawidłowy adres e-mail.
                            </div>
                        </div>
                    </div>
                    <div class="col-auto ml-auto mr-auto w-100 mb-3">
                        <span class="form-text">Hasło(8+ znaków, co najmniej duża, mała litera, cyfra i/lub znak specjalny):</span>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control passwd" name="passwd" placeholder="Hasło" title="Minimum 8 znaków, co najmniej duża, mała litera, cyfra i/lub znak specjalny">
                            <div class="invalid-feedback">
                                Nieprawidłowe hasło.
                            </div>
                        </div>
                    </div>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Rejestruj">
                <p class="valid-reg"></p>
            </form>';
    }

    function reg($db)
    {
        $args = [
            'userName' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                //4-20 znaków
                'options' => ['regexp' => '/^(?=.{4,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._]+(?<![_.])$/']
            ],
            'fullName' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                //min 3 znaków, polskie znaki dozwolone
                'options' => ['regexp' => '/^[a-zA-ZąćęłńóśżźĄĆĘŁŃÓŚŻŹ ]{3,}$/']
            ],
            'email' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                'options' => ['regexp' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/']
            ],
            'passwd' => [
                'filter' => FILTER_VALIDATE_REGEXP,
                //minimum 8 znaków, co najmniej duża, mała litera, cyfra i/lub znak spcjalny
                'options' => ['regexp' => '/^(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/']
            ]
        ];

        $data = filter_input_array(INPUT_POST, $args);

        $errors = array();
        $same = false;
        if (is_array($data)) {
            $sql = "SELECT userName, email FROM users";
            $result = $db->select($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    if ($row["userName"] == $data["userName"]) {
                        $_SESSION["form-same-userName"] = true;
                        $same = true;
                    }
                    if ($row["email"] == $data["email"]) {
                        $_SESSION["form-same-email"] = true;
                        $same = true;
                    }
                }
            }

            foreach ($data as $key => $val) {
                if ($val == "" or $val == NULL) {
                    array_push($errors, $key);
                }
            }
        }

        $sql = "";

        if (count($errors) == 0 && $same == false) {
            $userName = $data["userName"];
            $fullName = $data["fullName"];
            $email = $data["email"];
            $passwd = password_hash($data["passwd"], PASSWORD_DEFAULT);
            $date = new DateTime();
            $date = $date->format("Y-m-d H:i:s");

            $sql = "INSERT INTO users VALUES (NULL, '$userName', '$fullName', '$email', '$passwd', '100', '$date');";
        } else {
            if (is_array($errors)) {
                $_SESSION["form-invalid"] = $errors;
            }
        }

        return $sql;
    }
}
