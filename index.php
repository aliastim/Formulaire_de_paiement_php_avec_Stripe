<!DOCTYPE html>

<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <style>

        </style>
    </head>
    <body>
        <div class="container">
            <form action="payment.php" method="post" id="payment_form">
                <!-- Champs hors paiement -->
                <input type="text" name="name" placeholder="Votre nom" required value="Timothée">
                <input type="email" name="email" placeholder="Votre email" required value="timello@hotmail.fr">

                <!-- Champs pour le paiement -->
                <!-- l'attribut data-strip permet d'informer stripe du rôle de chaque input -->
                <input type="text" placeholder="Code de carte bleue" data-stripe="number" required value="4242 4242 4242 4242">
                <input type="text" placeholder="MM" data-stripe="exp_month" required value="10">
                <input type="text" placeholder="YY" data-stripe="exp_year" required value="21">
                <input type="text" placeholder="CVC" data-stripe="cvc" required value="123">

                <button type="submit">Acheter</button>
            </form>

        </div>

        <!-- Lien vers stripe -->
        <script src="https://js.stripe.com/v2/"></script>

        <!-- import de jquery -->
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>

        <!-- Processus stripe -->
        <script>
            Stripe.setPublishableKey('MA_CLE_PUBLIQUE') /*Clé publique*/
            var $form = $('#payment_form')

            $form.submit(function (e) {

                e.preventDefault() /*Permet d'empécher la soumission puisque le formulaire doit être envoyé à Stripe*/

                $form.find('.button').attr('disbled', true) /*Permet de désactiver le bouton d'envoi pour éviter les paiements multiple*/

                Stripe.card.createToken($form, function (status, response) {

                    if (response.error)
                    {
                        $form.find('.message').remove(); /*Supprime les messages d'erreurs précédent s'il y en a*/
                        $form.prepend('<div class="message"><p>'+ response.error.message +'</p></div>') /*S'il y a une erreur, crée une div avec le message*/
                    } else
                    {
                        var token = response.id /*Récupère le token renvoyé par stripe*/
                        $form.append($('<input type="hidden" name="stripeToken">').val(token)) /*Stocke le token dans un input*/
                        $form.get(0).submit() /*On soumet le formulaire*/
                    }

                })
            })

        </script>




    </body>
</html>
