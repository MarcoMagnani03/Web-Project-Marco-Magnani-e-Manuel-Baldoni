<section>
    <header>
        <h2>Marche</h2>
    </header>

    <form>
        <button type="button" onclick="aggiungiNuovaMarca()">
            <span aria-hidden="true" class="fa-solid fa-circle-plus"></span>
            <span class="fa-sr-only">Crea una nuova marca</span>
            Crea una nuova marca    
        </button>
        
        <input type="search" placeholder="Cerca per nome" />
        <button type="submit">
            <span aria-hidden="true" class="fa-solid fa-magnifying-glass"></span>
            <span class="fa-sr-only">Cerca</span>
            Cerca
        </button>
    </form>

    <?php if(count($templateParams["marche"]) == 0): ?>
        <p>Non ci sono marche disponibili al momento. Crea una nuova marca utilizzando il pulsante sopra.</p>
    <?php else:
        $marche = $templateParams["marche"]; 
    ?>
        <section>
            <h2 class="sr-only">Marche</h2>
            <?php foreach($marche as $marca): ?>
                <article data-id="<?php echo htmlspecialchars($marca['codice']); ?>">
                    <header>
                        <h3 data-editable="false"><?php echo htmlspecialchars($marca["titolo"]); ?></h3>
                        <input type="text" value="<?php echo htmlspecialchars($marca["titolo"]); ?>" />
                    </header>
                    <footer>
                        <form action="#">
                            <?php $codiceMarca = htmlspecialchars($marca["codice"]); ?>
                            <button type="button" id="modificaMarca" name="modificaMarca" aria-label="Modifica marca" onclick="toggleEditMode(this)">
                                <span aria-hidden="true" class="fa-solid fa-edit"></span>
                                <span class="fa-sr-only">Modifica marca</span>
                            </button>
                            
                            <button type="button" id="salvaMarca" name="salvaMarca" aria-label="Salva modifica" onclick="saveMarca(this, <?php echo $codiceMarca ?>)">
                                <span aria-hidden="true" class="fa-solid fa-floppy-disk"></span>
                                <span class="fa-sr-only">Salva modifica</span>
                            </button>
                            
                            <button type="button" id="eliminaMarca" name="eliminaMarca" aria-label="Elimina marca" onclick="deleteMarca(<?php echo $codiceMarca ?>)">
                                <span aria-hidden="true" class="fa-solid fa-trash"></span>
                                <span class="fa-sr-only">Elimina marca</span>
                            </button>
                        </form>
                    </footer>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</section>
