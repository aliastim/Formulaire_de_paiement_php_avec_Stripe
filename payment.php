<?php

$token = $_POST['stripeToken'];
$email = $_POST['email'];
$name = $_POST['name'];

if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($name) && !empty($token))
{
    require ('stripe.php');
    $stripe = new Stripe('MA_CLE_SECRETE'); /*Clé secrète Stripe*/
    $customer = $stripe->api('customers', [
        'source' => $token,
        'description' => $name, /*Information complémentaire pour identifier les clients sur Stripe (facultatif)*/
        'email' => $email, /*Information complémentaire pour identifier les clients sur Stripe (facultatif)*/
    ]);

    /*Pour un paiement simple (pas un abonnement) */
    $charge = $stripe->api('charges', [
        'amount' => 1000, /*Montant d'achat : 1000 = 10,00 € */
        'currency' => 'eur',
        'customer' => $customer->id,
    ]);

    var_dump($charge);
    die('Bravo le paiement a bien été enregistré');
}