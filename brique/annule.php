<?php
include 'config/client.php';
include 'utils/error-handler.php';
include 'utils/functions.php';
include 'utils/auth.php';

// Force HTTPS only if force_https = true (cf config/client.php)
if ( $force_https ) { include 'utils/force-https.php'; }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Paiement annulé | Centre de Pathologie</title>
  <meta name="description" content="Votre paiement a été annulé !">
  <meta name="robots" content="noindex, nofollow, noodp">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php echo $client_dir_ui_js ?>/static/favicon-anapath-amiens.png" />
</head>
<?php include 'assets/style.css.php'; ?>
<body>
  <?php
  // Vérification RSA de la requète - Securité !
  $IS_AUTH_REQUEST = IsAuthRequest();

  if ( $IS_AUTH_REQUEST ) { // Si le corps de la requète n'est pas modifié et provient bien de e-transactions
  ?>
    <div class="entete">
      <h1>Transaction annulée</h1>
    </div>
    <div class="info">
      <?php
        echo verifBeforePrintOut($client_prv_email, 'error');
        echo verifBeforePrintOut($client_prv_ddn, 'error');
        echo verifBeforePrintOut($client_pbx_ref, 'error');
        echo verifBeforePrintOut($client_pbx_montant, 'error');
        echo verifBeforePrintOut($client_pbx_type_paiement, 'error');
        echo verifBeforePrintOut($client_pbx_cb, 'error');
        echo verifBeforePrintOut($client_pbx_transaction, 'error');
        echo verifBeforePrintOut($client_pbx_date, 'error');
        echo verifBeforePrintOut($client_pbx_heure, 'error');
        echo verifBeforePrintOut($client_pbx_autorisation, 'error');
        echo verifBeforePrintOut($client_pbx_error, 'error');
       ?>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
      <button onclick="window.print();">Imprimer ce rapport</button>
    </div>
  <?php
  } else if ( $IS_AUTH_REQUEST === 0 ) { // Requète non sécurisé.
  ?>
    <div class="entete">
      <h1>Requète non signée</h1>
    </div>
    <div class="info">
      <p class="alert">Il semble que les données envoyées n'ont pas pu être vérifié, ou qu'il s'agit d'une tentative de pishing contre vous.</p>
      <p class="alert">Une vérification de la clé publique est nécessaire.</p>
      <p class="alert">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
      <button onclick="window.print();">Imprimer ce rapport</button>
    </div>
  <?php
  } else { // Problème interne (dépendances, ouverture clé, etc ...)
  ?>
    <div class="entete">
      <h1>Problème interne de décodage signature</h1>
    </div>
    <div class="info">
      <p class="error">Il semble qu'il y ai eu un problème interne de décodage signature pour s'assurer de l'intégrité de vos données. Une maintenance système est nécessaire.</p>
      <p class="error">Par mesure de sécurité, nous bloquons la requète.</p>
      <p class="error">Merci de contacter votre Centre de Pathologie pour signaler ce problème ou sur <a href="mailto:<?php echo $client_email; ?>" title="Envoyer un e-mail au Centre de Pathologie des Hauts de France"><?php echo $client_email; ?></a></p>
      <button onclick="window.location.href = '<?php echo $client_url_server.$client_dir_ui_js ?>';">Réessayer</button>
      <button onclick="window.print();">Imprimer ce rapport</button>
    </div>
  <?php
  }
  ?>
</body>
</html>
