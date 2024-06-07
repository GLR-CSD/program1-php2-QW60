<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productenlijst</title>
    <link rel="stylesheet" href="public/css/simple.css">
</head>
<body>
<h1>Productenlijst</h1>
<table>
    <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Artiesten</th>
        <th>Release Datum</th>
        <th>URL</th>
        <th>Afbeelding</th>
        <th>Prijs</th>
    </tr>
    <?php if (isset($albums) && is_array($albums)): ?>
        <?php foreach ($albums as $album): ?>
            <tr>
                <td><?= htmlspecialchars($album->getID()) ?></td>
                <td><?= htmlspecialchars($album->getNaam()) ?></td>
                <td><?= htmlspecialchars($album->getArtiesten()) ?></td>
                <td><?= htmlspecialchars($album->getReleaseDatum()) ?></td>
                <td><a href="<?= htmlspecialchars($album->getURL()) ?>" target="_blank"><?= htmlspecialchars($album->getURL()) ?></a></td>
                <td><img src="<?= htmlspecialchars($album->getAfbeelding()) ?>" alt="Afbeelding van <?= htmlspecialchars($album->getNaam()) ?>" width="50" height="50"></td>
                <td><?= htmlspecialchars($album->getPrijs()) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7">Geen albums gevonden.</td>
        </tr>
    <?php endif; ?>
</table>

<div class="notice">
    <h2>Product Toevoegen:</h2>
    <?php if (!empty($errors) && is_array($errors)): ?>
        <div style="color: red;">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form action="toevoegen.php" method="post">
        <label for="naam">Naam:</label>
        <input type="text" id="naam" name="naam" value="<?= htmlspecialchars($formValues['naam'] ?? '') ?>" required>
        <?php if (isset($errors['naam'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['naam']) ?></span>
        <?php endif; ?><br>

        <label for="artiesten">Artiesten:</label>
        <input type="text" id="artiesten" name="artiesten" value="<?= htmlspecialchars($formValues['artiesten'] ?? '') ?>" required>
        <?php if (isset($errors['artiesten'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['artiesten']) ?></span>
        <?php endif; ?><br>

        <label for="release_datum">Release Datum:</label>
        <input type="date" id="release_datum" name="release_datum" value="<?= htmlspecialchars($formValues['release_datum'] ?? '') ?>" required>
        <?php if (isset($errors['release_datum'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['release_datum']) ?></span>
        <?php endif; ?><br>

        <label for="url">URL:</label>
        <input type="url" id="url" name="url" value="<?= htmlspecialchars($formValues['url'] ?? '') ?>" required>
        <?php if (isset($errors['url'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['url']) ?></span>
        <?php endif; ?><br>

        <label for="afbeelding">Afbeelding URL:</label>
        <input type="url" id="afbeelding" name="afbeelding" value="<?= htmlspecialchars($formValues['afbeelding'] ?? '') ?>" required>
        <?php if (isset($errors['afbeelding'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['afbeelding']) ?></span>
        <?php endif; ?><br>

        <label for="prijs">Prijs:</label>
        <input type="number" step="0.01" id="prijs" name="prijs" value="<?= htmlspecialchars($formValues['prijs'] ?? '') ?>" required>
        <?php if (isset($errors['prijs'])): ?>
            <span style="color: red;"><?= htmlspecialchars($errors['prijs']) ?></span>
        <?php endif; ?><br>

        <input type="submit" value="Toevoegen">
    </form>
</div>

</body>
</html>
