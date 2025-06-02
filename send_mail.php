<?php
// Zkontrolujeme, zda byl formulář odeslán metodou POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // == OŠETŘENÍ VSTUPŮ ==
    // htmlspecialchars chrání před XSS útoky (např. skripty ve jméně)
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // == VALIDACE EMAILU ==
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Neplatná e-mailová adresa.";
        exit;
    }

    // == KOMPILACE EMAILU ==
    $to = 'info@kadlanmontage.com'; // Příjemce e-mailu
    $subject = 'Nová zpráva z kontaktního formuláře';
    $body = "Jméno: $name\nE-mail: $email\n\nZpráva:\n$message";

    // Záhlaví e-mailu – nastavení odesílatele
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // == ODESLÁNÍ EMAILU ==
    if (mail($to, $subject, $body, $headers)) {
        echo "Zpráva byla úspěšně odeslána.";
    } else {
        echo "Nepodařilo se odeslat zprávu. Zkuste to prosím znovu.";
    }

} else {
    // Pokud stránku někdo načte přímo bez POST požadavku
    echo "Přístup zamítnut - formulář nebyl odeslán správně.";
}
?>