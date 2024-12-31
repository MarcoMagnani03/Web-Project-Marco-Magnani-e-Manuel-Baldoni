<?php $prodotto = isset($templateParams["prodotto"]) ? $templateParams["prodotto"] : null;?>
<form method="POST" action=<?php echo $prodotto ? "gestisci-prodotto.php" : "nuovo-prodotto.php"?> enctype="multipart/form-data">
    
    <h2><?php echo $prodotto ? "Modifica prodotto" : "Nuovo prodotto"; ?></h2>


    <?php if ($prodotto): ?>
        <input type="hidden" name="codice" id="codice" value=<?php echo $prodotto["codice"]?> >
    <?php endif; ?>

    <label for="tipologia">
        Tipo prodotto:
        <select name="tipologia" id="tipologia" required>
            <option value="" disabled <?= !$prodotto ? 'selected' : '' ?>>Tipo</option>
            <?php foreach($templateParams["tipologie_prodotti"] as $tipologia): ?>
                <option value="<?php echo $tipologia["nome"]; ?>" 
                    <?php echo $prodotto && $prodotto["tipologia"] === $tipologia["nome"] ? 'selected' : ''; ?>>
                    <?php echo $tipologia["nome"]; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label for="nome">
        Nome
        <input type="text" id="nome" name="nome" required placeholder="inserisci il nome del prodotto" 
               value="<?php echo $prodotto ? htmlspecialchars($prodotto["nome"]) : ''; ?>" />
    </label>

    <label for="descrizione">
        Descrizione
        <textarea name="descrizione" id="descrizione" placeholder="inserisci la descrizione">
            <?php echo $prodotto ? htmlspecialchars($prodotto["descrizione"]) : ''; ?>
        </textarea>
    </label>

    <label for="prezzo">
        Prezzo
        <input type="number" id="prezzo" step=".01" required name="prezzo" max="999999999" placeholder="10.99" 
               value="<?php echo $prodotto ? htmlspecialchars($prodotto["prezzo"]) : ''; ?>" />
    </label>

    <label for="quantita">
        Quantità in deposito
        <input type="number" id="quantita" name="quantita" required placeholder="1" 
               value="<?php echo $prodotto ? htmlspecialchars($prodotto["quantita"]) : ''; ?>" />
    </label>

    <label for="marche">
        Marche:
        <select id="marche" name="marche">
            <option value="" disabled <?= !$prodotto ? 'selected' : '' ?>>Marca</option>
            <?php foreach($templateParams["marche"] as $marca): ?>
                <option value="<?php echo $marca["codice"]; ?>" 
                    <?php echo $prodotto && $prodotto["marca"] === $marca["codice"] ? 'selected' : ''; ?>>
                    <?php echo $marca["titolo"]; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label>

    <label for="disponibile">
        Disponibile
        <input type="checkbox" id="disponibile" name="disponibile" 
               <?php echo $prodotto && $prodotto["stato"] == "disponibile" ? 'checked' : ''; ?> />
    </label>

    <label for="foto">
        Aggiungi le foto
        <input type="file" id="foto" name="foto[]" accept=".jpg,.jpeg,.png,.gif" multiple aria-describedby="foto-info"/>
    </label>
    <input type="button" id="rimuovi-foto" value="Rimuovi tutte le foto selezionate">
    <p id="foto-info">Seleziona immagini in formato JPG, JPEG, PNG o GIF. Puoi caricare più di una foto. <strong>Attenzione la prima immagine sarà la principale</strong></p>

    <?php if(isset($templateParams["immagini_prodotto"])) :?>
        <?php foreach ($templateParams["immagini_prodotto"] as $index => $immagine): ?>
            <div class="immagine-container">
                <img src="<?php echo htmlspecialchars($immagine); ?>" alt="Immagine prodotto" class="immagine-prodotto"/>
                <input type="button" class="rimuovi-immagine" value="Rimuovi" data-immagine="<?php echo htmlspecialchars($immagine); ?>"/>
            </div>
        <?php endforeach; ?>
        <!-- Input nascosto per raccogliere le immagini da rimuovere -->
        <input type="hidden" name="immagini_da_rimuovere" id="immagini_da_rimuovere" value=""/>
    <?php endif?>



    <?php if ($prodotto && isset($prodotto["caratteristiche"])): ?>
        <?php foreach ($prodotto["caratteristiche"] as $codice => $caratteristica): ?>
            <div class="campi-dinamici">
                <label for="caratteristiche_<?php echo htmlspecialchars($codice); ?>">
                    <?php echo htmlspecialchars($caratteristica["nome"]); ?>
                    <input type="text" 
                        id="caratteristiche_<?php echo htmlspecialchars($codice); ?>" 
                        name="caratteristiche[<?php echo htmlspecialchars($codice); ?>][valore]" 
                        placeholder="<?php echo htmlspecialchars($caratteristica["descrizione"]); ?>" 
                        value="<?php echo htmlspecialchars($caratteristica["contenuto"]); ?>" 
                        required />
                </label>
                <input type="hidden" 
                    name="caratteristiche[<?php echo htmlspecialchars($codice); ?>][codice]" 
                    value="<?php echo htmlspecialchars($caratteristica["codice"]); ?>" />
            </div>
        <?php endforeach; ?>
    <?php endif; ?>



    <button type="submit">
        <span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
        <span class="fa-sr-only">Crea prodotto</span>
        <?php echo $prodotto ? 'Modifica prodotto' : 'Crea prodotto'; ?>
    </button>

    <a href="index.php">
        <span aria-hidden="true" class="fa-solid fa-circle-xmark"></span>
        <span class="fa-sr-only">Annulla</span>
        Annulla
    </a>
</form>
