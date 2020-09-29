//////////LOGIN FORM
function invalidLogin() {
    const elem = document.querySelector(".invalid-login");
    elem.innerHTML = "Nieprawidłowa nazwa użytkownika lub hasło.";
}

//////////REG FORM
function validReg() {
    const elem = document.querySelector(".valid-reg");
    elem.innerHTML = "Zarejestrowano pomyślnie!";
}

function errorUserName() {
    const userNameElem = document.querySelector(".userName");
    userNameElem.classList.add("is-invalid");

    const userNameFeedback = document.querySelector(".userName-feedback");
    userNameFeedback.innerHTML = "Istnieje już taka nazwa użytkownika.";
}

function errorEmail() {
    const userNameElem = document.querySelector(".email");
    userNameElem.classList.add("is-invalid");

    const userNameFeedback = document.querySelector(".email-feedback");
    userNameFeedback.innerHTML = "Istnieje już konto z takim adresem e-mail.";
}

//////////REG AND ADD PRODUCT FORM
function errorForm(key) {
    const elem = document.querySelector(`.${key}`);
    elem.classList.add("is-invalid");
}

//////////ADD PRODUCT FORM
function validAdd() {
    const elem = document.querySelector(".valid-add");
    elem.innerHTML = "Wystawiono pomyślnie!";
}

//////////ADD TO CART
function validAddToCart() {
    const elem = document.querySelector(".valid-add-to-cart");
    elem.innerHTML = "Dodano pomyślnie!";
}

function invalidAddToCart() {
    const elem = document.querySelector(".invalid-add-to-cart");
    elem.innerHTML = "Nieprawidłowa ilość.";
}

//////////REMOVE FROM STORE
function removedFromStore() {
    const elem = document.querySelector(".removed-from-store");
    elem.innerHTML = "Usunięto pomyślnie!";
}

//////////REMOVE FROM CART
function removedFromCart() {
    const elem = document.querySelector(".removed-from-cart");
    elem.innerHTML = "Usunięto pomyślnie!";
}

//////////PAY
function validPay() {
    const elem = document.querySelector(".valid-pay");
    elem.innerHTML = "Zapłacono za wszystkie produkty!";
}

function invalidPay() {
    const elem = document.querySelector(".invalid-pay");
    elem.innerHTML = "Niewystarczające środki na koncie.";
}

//////////PAY
function validAddCash() {
    const elem = document.querySelector(".valid-add");
    elem.innerHTML = "Dodano pomyślnie środki do Twojego konta!";
}