<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./assets/css/app.css">
    
    <title>Historique des visites</title>
</head>
<body>
    <div class="container">
        <h1>Historique des visiteurs</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Pays</th>
                    <th scope="col">Adresse IP</th>
                    <th scope="col">Date-heure</th>
                    <th scope="col">Carte</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visites as $visite): ?>
                    <tr class="visite">
                        <th scope="row" class="idVisite">#<?= $visite['idVisite'] ?></td>

                        <td class="geoCountryCode">
                            <?php if ($visite['geoCountryCode'] !== null): ?>
                                <img src="https://countryflagsapi.com/svg/<?= $visite['geoCountryCode'] ?>">
                            <?php else: ?>
                                <i class="bi-question-circle" title="Inconnue"></i>
                            <?php endif ?>
                        </td>

                        <td class="ipAddress">
                            <?= $visite['ipAddress'] ?>
                            <i class="bi-info-circle" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="right" data-bs-content="<?= $visite['userAgent'] ?>"></i>
                        </td>

                        <td class="createdAt"><?= $visite['createdAtFormated'] ?></td>

                        <td class="map">
                            <?php if ($visite['geoLatitude'] !== null && $visite['geoLongitude'] !== null): ?>
                                <a href="https://www.google.com/maps/search/?api=1&query=<?= $visite['geoLatitude'] ?>,<?= $visite['geoLongitude'] ?>&hl=fr" target="new">
                                <i class="bi-pin-map-fill"></i>
                                <a>
                            <?php else: ?>
                                <i class="bi-pin-map" title="Indisponible"></i>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script type="text/javascript">
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(item => new bootstrap.Popover(item))
    </script>
</body>
</html>
